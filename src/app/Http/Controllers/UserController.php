<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ImageUploaderTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ImageUploaderTrait;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('role:admin')->only(['destroy', 'restore', 'delete', 'trashed']);
    }

    public function index()
    {
        $users = $this->userService->list();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $this->userService->store($request->validated());
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $user = $this->userService->find($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $roles = Role::pluck('name', 'id');
        $user = $this->userService->find($id);
        return view('users.edit', compact('roles', 'user'));
    }

    public function update($id, UserRequest $request)
    {
        $this->userService->update($id, $request->validated());
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $this->userService->destroy($id);
        return redirect()->route('users.index');
    }

    public function trashed()
    {
        $users = $this->userService->listTrashed();
        return view('users.trashed', compact('users'));
    }

    public function restore($id)
    {
         $this->userService->restore($id);
        return redirect()->route('users.trashed');
    }

    public function delete($id)
    {
        $this->userService->delete($id);
        return redirect()->route('users.trashed');
    }

}
