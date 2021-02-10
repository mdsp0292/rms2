<?php


namespace App\Services;


use App\Models\Account;
use App\Models\Opportunity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public static function getTotalCustomerCount(): int
    {
        $accounts = (Auth::user()->isOwner())
            ? Account::all()
            : Account::whereUserId(Auth::user()->id)->get();

        return $accounts->count();
    }


    public static function getTotalOpportunitiesCount(): int
    {
        $opportunities = (Auth::user()->isOwner())
            ? Opportunity::all()
            : Opportunity::whereHas('account', function ($query){
                $query->where('user_id','=',Auth::user()->id);
            })->get();

        return $opportunities->count();
    }

    public static function getTotalOpportunitiesValue(): int
    {
        return (Auth::user()->isOwner())
            ? Opportunity::all()->sum('amount')
            : Opportunity::whereHas('account', function ($query){
                $query->where('user_id','=',Auth::user()->id);
            })->sum('referral_amount');
    }


    public static function getOpportunitiesValueForThisMonth(): int
    {
        $startOfMonth = Carbon::now()->firstOfMonth()->toDateString();

        if(Auth::user()->isOwner()){
            return Opportunity::where('created_at','>=',$startOfMonth)
                ->sum('amount');
        }

        return Opportunity::whereHas('account', function ($query){
                $query->where('user_id','=',Auth::user()->id);
            })
            ->where('created_at','>=',$startOfMonth)
            ->sum('referral_amount');
    }
}
