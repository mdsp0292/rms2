<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Lists\UsersList;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    public function __construct(private UserService $userService)
    {
        //..
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Users/UsersList', [
            'filters'       => Request::all(['search']),
            'table_columns' => UsersList::get(),
            'table_rows'    => $this->userService->getList()
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Users/UserCreate');
    }


    /**
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->userService->createNewUser($request->validated());

        return Redirect::route('users')->with('success', 'User created.');
    }

    /**
     * @param User $user
     * @return Response
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Users/Edit', [
            'user' => new UserResource($user),
        ]);
    }

    /**
     * @param User $user
     * @param UserUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(User $user, UserUpdateRequest $request): RedirectResponse
    {
        $user->update(
            $request->validated()
        );

        return Redirect::back()->with('success', 'User updated.');
    }

    /**
     * @param User $user
     * @param UserDeleteRequest $request
     * @return RedirectResponse
     */
    public function destroy(User $user, UserDeleteRequest $request)
    {
        $user->delete();

        return Redirect::back()->with('success', 'User deleted.');
    }

}
