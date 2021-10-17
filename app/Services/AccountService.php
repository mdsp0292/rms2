<?php


namespace App\Services;


use App\Http\Resources\AccountsCollection;
use App\Jobs\CreateCustomerInStripeJob;
use App\Models\Account;
use App\Models\Opportunity;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;

class AccountService
{
    /**
     * @return AccountsCollection
     */
    public function getAccountsList(): AccountsCollection
    {
        return new AccountsCollection(
            Account::query()
                ->select(['id', 'name', 'email', 'phone', 'street', 'city', 'state', 'country', 'post_code'])
                ->when(!Auth::user()->isOwner(), function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                ->filter(Request::only(['search']))
                ->paginate(50)
                ->appends(Request::all())
        );

    }


    /**
     * @param array $data
     * @return int
     * @throws ValidationException
     */
    public function checkAndStore(array $data): int
    {
        if ($this->isDuplicateAccount($data['email'])) {
            throw ValidationException::withMessages(['email' => 'Looks like account with same email exists']);
        }

        $newAccount = new Account();
        $newAccount->name = $data['name'];
        $newAccount->email = $data['email'];
        $newAccount->phone = $data['phone'];
        $newAccount->street = $data['street'];
        $newAccount->city = $data['city'];
        $newAccount->state = $data['state'];
        $newAccount->country = $data['country'];
        $newAccount->post_code = $data['post_code'];
        $newAccount->user_id = Auth::id();
        $newAccount->save();

        CreateCustomerInStripeJob::dispatch($newAccount)->afterCommit();

        return $newAccount->id;
    }


    /**
     * check if associated opportunities are older than 30 days if same email exist
     * @param $accountEmail
     * @return bool
     */
    public function isDuplicateAccount($accountEmail): bool
    {
        $accountDuplicateCheck = Account::query()
            ->select('id', 'email')
            ->where('email', '=', $accountEmail);

        //check if any customer exist with same email
        if(!$accountDuplicateCheck->exists()){
            return true;
        }

        return $this->checkIfOpportunityIsOlderThan30Days($accountDuplicateCheck->first());

    }

    /**
     * Check if duplicate account has opportunity older than 30 days
     * allow duplicate account only if older than 30 days
     *
     * @param Account $account
     * @return bool
     */
    private function checkIfOpportunityIsOlderThan30Days(Account $account): bool
    {
        //if no opportunities dont allow duplicate customer
        if(!$account->opportunities()->exists()){
            return false;
        }

        //check if any opportunities is older than 30 days
        $latestOpportunity = $account->opportunities()
            ->orderBy('opportunities.created_at','desc')
            ->first();

        return now()->subDays(30)->lte($latestOpportunity->created_at);
    }

    /**
     * @return array
     */
    public function getAccountsListForSelect(): array
    {
        return Account::query()
            ->select('id', 'name')
            ->get()->map(function ($account) {
                return [
                    'value' => $account->id,
                    'label' => $account->name
                ];
            })->all();
    }


    public function getAccountInfoFrForStripe(Account $account)
    {
        return [
            'description' => $account->name,
            'name'        => $account->name,
            'email'       => $account->email,
            'address'     => [
                'line1'   => $account->street,
                'city'    => $account->city,
                'state'   => $account->state,
                'country' => $account->country
            ],
            'metadata'    => [
                'rms_account_id' => $account->id
            ],
        ];
    }
}
