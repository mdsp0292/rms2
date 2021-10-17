<?php


namespace App\Services;


use App\Http\Resources\AccountsCollection;
use App\Models\Account;
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
                ->select(['id','name','email','phone', 'street','city','state','country','post_code'])
                ->when(!Auth::user()->isOwner(), function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                ->filter(Request::only(['search']))
                ->paginate()
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
        if (self::isDuplicateAccount($data['email'])) {
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

        return $newAccount->id;
    }


    /**
     * check if associated opportunities are older than 30 days if same email exist
     * @param $accountEmail
     * @return bool
     */
    public static function isDuplicateAccount($accountEmail): bool
    {
        $duplicateEmailCount = Account::query()
            ->select('id', 'email')
            ->where('email', '=', $accountEmail)
            ->count();

        return $duplicateEmailCount > 0;
    }

    /**
     * @return array
     */
    public function getAccountsListForSelect(): array
    {
        return Account::query()
            ->select('id', 'name')
            ->get()->map(function ($account){
                return[
                    'value' => $account->id,
                    'label' => $account->name
                ];
            })->all();
    }
}
