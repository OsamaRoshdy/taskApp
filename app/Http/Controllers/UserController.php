<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Traits\ImageUploaderTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ImageUploaderTrait;

    public function __construct()
    {
        $this->middleware('role:admin')->only(['destroy', 'restore', 'delete', 'trashed']);
    }

    public function index()
    {
        $users = User::select(['id', 'firstname', 'lastname', 'username', 'email', 'photo'])->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'id');
        return view('users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['photo'] = $this->storeImage($request->photo, 'users');
        $user = User::create($data);
        $user->roles()->sync([$request->roles]);

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id');
        return view('users.edit', compact('roles', 'user'));
    }

    public function update(User $user, UserRequest $request)
    {
        $data = $request->except(['photo', 'password', 'password_confirmation', 'roles']);
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        if ($request->photo) {
            $data['photo'] = $this->updateImage($request->photo, $user->photo,'users');
        }

        $user->update($data);
        $user->roles()->sync([$request->roles]);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->select(['id', 'firstname', 'lastname', 'username', 'email'])->paginate(10);
        return view('users.trashed', compact('users'));
    }

    public function restore($id)
    {
        User::where('id', $id)->withTrashed()->restore();
        return redirect()->route('users.trashed');
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->withTrashed()->first();
        $this->deleteImage($user->photo, 'users');
        $user->forceDelete();
        return redirect()->route('users.trashed');
    }

}
