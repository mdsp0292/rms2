<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpportunityStoreRequest;
use App\Http\Requests\OpportunityUpdateRequest;
use App\Http\Resources\OpportunitiesCollection;
use App\Http\Resources\OpportunitiesResource;
use App\Models\Account;
use App\Models\Opportunity;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class OpportunitiesController extends Controller
{

    public function index()
    {
        $query = (Auth::user()->isOwner())
            ? Opportunity::with(['account'])
            : Opportunity::whereHas('account', function ($query){
                $query->where('user_id','=',Auth::user()->id);
            });

        $opportunity = $query->orderBy('created_at')
            ->filter(Request::only('search', 'trashed'))
            ->paginate();

        return Inertia::render('Opportunities/Index', [
            'filters'       => Request::all('search', 'role', 'trashed'),
            'opportunities' => new OpportunitiesCollection($opportunity),
            'is_owner'      => Auth::user()->isOwner()
        ]);
    }


    public function create()
    {
        if(!Auth::user()->isOwner()){
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Opportunities/Create',[
            'accounts'    => Account::all('id as value', 'name as label'),
            'products'    => Product::all('id as value', 'name as label', 'amount'),
            'salesStages' => Opportunity::$salesStages
        ]);
    }


    public function store(OpportunityStoreRequest $request)
    {
        if(!Auth::user()->isOwner()){
            abort(403, 'Unauthorized action.');
        }

        $formData = $request->validated();
        $formData['created_by'] = Auth::user()->id;
        Opportunity::create($formData);

        return Redirect::route('opportunities')->with('success', 'Opportunity Created');
    }




    public function edit(Opportunity $opportunity)
    {
        if(!Auth::user()->isOwner()){
            abort(403, 'Unauthorized action.');
        }

        return Inertia::render('Opportunities/Edit', [
            'accounts'    => Account::all('id as value', 'name as label'),
            'products'    => Product::all('id as value', 'name as label', 'amount'),
            'salesStages' => Opportunity::$salesStages,
            'opportunity' => new OpportunitiesResource($opportunity),
        ]);
    }


    public function update(Opportunity $opportunity,OpportunityUpdateRequest $request)
    {
        if(!Auth::user()->isOwner()){
            abort(403, 'Unauthorized action.');
        }

        $opportunity->update(
            $request->validated()
        );

        return Redirect::back()->with('success', 'Opportunity updated.');
    }


    public function destroy(Opportunity $opportunity)
    {
        $opportunity->delete();

        return Redirect::back()->with('success', 'Opportunity deleted.');
    }

    public function restore(Opportunity $opportunity)
    {
        $opportunity->restore();

        return Redirect::back()->with('success', 'Opportunity restored.');
    }
}
