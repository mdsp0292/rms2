<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpportunityStoreRequest;
use App\Http\Requests\OpportunityUpdateRequest;
use App\Http\Resources\OpportunitiesResource;
use App\Lists\OpportunitiesList;
use App\Models\Opportunity;
use App\Services\AccountService;
use App\Services\OpportunityService;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class OpportunitiesController extends Controller
{
    public function __construct(private OpportunityService $opportunityService)
    {
        //..
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Opportunities/OpportunitiesList', [
            'filters'       => Request::all(['search', 'role', 'trashed']),
            'table_columns' => OpportunitiesList::get(),
            'table_rows'    => $this->opportunityService->getList(),
            'is_owner'      => Auth::user()->isOwner()
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        abort_if(!Auth::user()->isOwner(), 403);

        return Inertia::render('Opportunities/Create', [
            'accounts'    => (new AccountService)->getAccountsListForSelect(),
            'products'    => (new ProductService)->getProductsListForSelect(),
            'salesStages' => Opportunity::salesStages()
        ]);
    }

    /**
     * @param OpportunityStoreRequest $request
     * @return RedirectResponse
     */
    public function store(OpportunityStoreRequest $request): RedirectResponse
    {
        abort_if(!Auth::user()->isOwner(), 403);

        $this->opportunityService->store($request->validated());

        return Redirect::route('opportunities')->with('success', 'Opportunity Created');
    }


    /**
     * @param Opportunity $opportunity
     * @return Response
     */
    public function edit(Opportunity $opportunity): Response
    {
        abort_if(!Auth::user()->isOwner(), 403);

        return Inertia::render('Opportunities/Edit', [
            'accounts'    => (new AccountService)->getAccountsListForSelect(),
            'products'    => (new ProductService)->getProductsListForSelect(),
            'salesStages' => Opportunity::salesStages(),
            'opportunity' => new OpportunitiesResource($opportunity),
        ]);
    }

    /**
     * @param Opportunity $opportunity
     * @param OpportunityUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(Opportunity $opportunity, OpportunityUpdateRequest $request): RedirectResponse
    {
        abort_if(!Auth::user()->isOwner(), 403);

        $opportunity->update(
            $request->validated()
        );

        return Redirect::back()->with('success', 'Opportunity updated.');
    }

    /**
     * @param Opportunity $opportunity
     * @return RedirectResponse
     */
    public function destroy(Opportunity $opportunity): RedirectResponse
    {
        abort_if(!Auth::user()->isOwner(), 403);

        $opportunity->delete();

        return Redirect::back()->with('success', 'Opportunity deleted.');
    }

    /**
     * @param Opportunity $opportunity
     * @return RedirectResponse
     */
    public function restore(Opportunity $opportunity): RedirectResponse
    {
        abort_if(!Auth::user()->isOwner(), 403);

        $opportunity->restore();

        return Redirect::back()->with('success', 'Opportunity restored.');
    }
}
