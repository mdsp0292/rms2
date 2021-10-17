<?php


namespace App\Services;


use App\Models\Account;
use App\Models\Opportunity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    /**
     * @return int[]
     */
    public function getStats()
    {
        return [
            'total_customers'                      => $this->getTotalCustomerCount(),
            'total_opportunities'                  => $this->getTotalOpportunitiesCount(),
            'total_opportunities_value'            => $this->getTotalOpportunitiesValue(),
            'total_opportunities_value_this_month' => DashboardService::getOpportunitiesValueForThisMonth()
        ];
    }
    /**
     * @return int
     */
    public function getTotalCustomerCount(): int
    {
        $accounts = (Auth::user()->isOwner())
            ? Account::all()
            : Account::whereUserId(Auth::user()->id)->get();

        return $accounts->count();
    }

    /**
     * @return int
     */
    public function getTotalOpportunitiesCount(): int
    {
        $opportunities = (Auth::user()->isOwner())
            ? Opportunity::all()
            : Opportunity::query()
                ->whereHas('account', function ($query){
                    $query->where('user_id','=',Auth::user()->id);
                })->get();

        return $opportunities->count();
    }

    /**
     * @return int
     */
    public function getTotalOpportunitiesValue(): int
    {
        return (Auth::user()->isOwner())
            ? Opportunity::all()->sum('amount')
            : Opportunity::query()
                ->whereHas('account', function ($query){
                    $query->where('user_id','=',Auth::user()->id);
                })->sum('referral_amount');
    }

    /**
     * @return int
     */
    public function getOpportunitiesValueForThisMonth(): int
    {
        $startOfMonth = Carbon::now()->firstOfMonth()->toDateString();

        if(Auth::user()->isOwner()){
            return Opportunity::query()
                ->where('created_at','>=',$startOfMonth)
                ->sum('amount');
        }

        return Opportunity::query()
            ->whereHas('account', function ($query){
                $query->where('user_id','=',Auth::user()->id);
            })
            ->where('created_at','>=',$startOfMonth)
            ->sum('referral_amount');
    }
}
