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
                    $query->where('accounts', '=', Auth::user()->id);
                })
                ->orderBy('opportunities.created_at')
                ->filter(Request::only(['search', 'trashed']))
                ->paginate()
        );
    }
}
