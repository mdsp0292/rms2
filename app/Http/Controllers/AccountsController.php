<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Resources\AccountsCollection;
use App\Http\Resources\AccountsResource;
use App\Models\Account;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountsController extends Controller
{

    public function index()
    {
        $accounts = (Auth::user()->isOwner()) ? Account::orderBy('created_at','desc')->paginate() : Account::whereUserId(Auth::user()->id)->paginate();

        return Inertia::render('Accounts/Index', [
            'filters' => Request::all(['search', 'trashed']),
            'accounts' => new AccountsCollection(
                $accounts->appends(Request::all())
            ),
        ]);
    }


    public function create()
    {
        return Inertia::render('Accounts/Create');
    }


    public function store(AccountStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        Account::create($data);

        return Redirect::route('accounts')->with('success', 'Account created.');
    }


    public function edit(Account $account)
    {
        return Inertia::render('Accounts/Edit', [
            'account' => new AccountsResource($account),
        ]);
    }


    public function update(Account $account, AccountUpdateRequest $request)
    {
        $account->update(
            $request->validated()
        );

        return Redirect::back()->with('success', 'Account updated.');
    }


    public function destroy(Account $account)
    {
        $account->delete();

        return Redirect::back()->with('success', 'Account deleted.');
    }

    public function restore(Account $account)
    {
        $account->restore();

        return Redirect::back()->with('success', 'Account restored.');
    }
}
