<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Resources\AccountsResource;
use App\Lists\AccountsList;
use App\Models\Account;
use App\Services\AccountsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AccountsController extends Controller
{
    public function __construct(private AccountsService $accountsService)
    {
        //..
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Accounts/AccountsList', [
            'filters'       => Request::all(['search', 'trashed']),
            'table_columns' => AccountsList::get(),
            'table_rows'    => $this->accountsService->getAccountsList()
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Accounts/Create');
    }

    /**
     * @param AccountStoreRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(AccountStoreRequest $request): RedirectResponse
    {
        $result = $this->accountsService->checkAndStore($request->validated());

        return $result ?
            Redirect::route('accounts.edit', $result)->with('success', 'Account created.') :
            back()->with('error', 'Error creating new account');
    }

    /**
     * @param Account $account
     * @return Response
     */
    public function edit(Account $account): Response
    {
        return Inertia::render('Accounts/Edit', [
            'account' => new AccountsResource($account),
        ]);
    }

    /**
     * @param Account $account
     * @param AccountUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(Account $account, AccountUpdateRequest $request): RedirectResponse
    {
        $account->update(
            $request->validated()
        );

        return Redirect::back()->with('success', 'Account updated.');
    }

    /**
     * @param Account $account
     * @return RedirectResponse
     */
    public function destroy(Account $account): RedirectResponse
    {
        $account->delete();

        return Redirect::back()->with('success', 'Account deleted.');
    }

    /***
     * @param Account $account
     * @return RedirectResponse
     */
    public function restore(Account $account): RedirectResponse
    {
        $account->restore();

        return Redirect::back()->with('success', 'Account restored.');
    }
}
