<?php

namespace App\Services;

use App\Http\Resources\OpportunitiesCollection;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class OpportunityService
{
    /**
     * @return OpportunitiesCollection
     */
    public function getList(): OpportunitiesCollection
    {
        return new OpportunitiesCollection(
            Opportunity::query()
                ->select([
                    'opportunities.id',
                    'opportunities.name as name',
                    'accounts.name as account',
                    'opportunities.sales_stage as sales_stage',
                    'opportunities.referral_percentage as referral_percentage',
                    'opportunities.referral_amount as referral_amount',
                    'opportunities.referral_start_date as referral_start_date',
                    'opportunities.created_by as created_by',
                    'opportunities.sale_start as sale_start',
                    'opportunities.sale_end as sale_end',
                    'opportunities.created_at as created_at',
                    'opportunities.deleted_at as deleted_at'
                ])
                ->join('accounts', 'accounts.id', '=', 'opportunities.account_id')
                ->when(Auth::user()->isOwner(), function ($query) {
                    $query->where('accounts.user_id', '=', Auth::user()->id);
                })
                ->orderBy('opportunities.created_at')
                ->filter(Request::only(['search', 'trashed']))
                ->paginate()
        );
    }

    /**
     * @param array $data
     */
    public function store(array $data)
    {
        $newOpp = new Opportunity();
        $newOpp->name = $data['name'];
        $newOpp->account_id = $data['account_id'];
        $newOpp->product_id = $data['product_id'];
        $newOpp->sales_stage = $data['sales_stage'];
        $newOpp->amount = $data['amount'];
        $newOpp->referral_percentage = $data['referral_percentage'];
        $newOpp->referral_amount = $data['referral_amount'];
        $newOpp->referral_start_date = $data['referral_start_date'];
        $newOpp->sale_start = $data['sale_start'];
        //$newOpp->sale_end = $data['sale_end'];
        $newOpp->created_by = Auth::id();
        $newOpp->save();

        //TODO:send email to owner
    }
}
