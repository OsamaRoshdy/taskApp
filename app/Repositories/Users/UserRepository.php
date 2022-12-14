<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Traits\ImageUploaderTrait;

class UserRepository implements UserRepositoryInterface
{
    use ImageUploaderTrait;

    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        return $this->model->select(['id', 'firstname', 'lastname', 'username', 'email', 'photo'])->paginate(10);
    }

    public function show($id)
    {
        return $this->model->findOrfail($id);
    }

    public function store(array $attributes)
    {
        $data = $attributes;
        $data['password'] = bcrypt($attributes['password']);
        $data['photo'] = $this->storeImage($attributes['photo'], 'users');
        $user = $this->model->create($data);
        $user->roles()->sync([$attributes['roles']]);
        return $user;
    }

    public function update(int $id, array $attributes)
    {

        $data = collect($attributes)->except(['password', 'photo'])->toArray();
        $user = $this->model->findOrfail($id);
        if (isset($attributes['password']) && $attributes['password'] !== null) {
            $data['password'] = bcrypt($attributes['password']);
        }
        if (isset($attributes['photo']) && !empty($attributes['photo'])) {
            $data['photo'] = $this->updateImage($attributes['photo'], $user->photo,'users');
        }

        $user->update($data);
        $user->roles()->sync([$attributes['roles']]);

        return $user;
    }

    public function destroy($id)
    {
        return $this->model->findOrfail($id)->delete();
    }

    public function listTrashed()
    {
        return $this->model::onlyTrashed()->select(['id', 'firstname', 'lastname', 'username', 'email'])->paginate(10);
    }

    public function restore($id)
    {
        return $this->model::withTrashed()->findOrFail($id)->restore();
    }

    public function delete($id)
    {
        $user = $this->model::withTrashed()->findOrFail($id);
        $this->deleteImage($user->photo, 'users');
        return $user->forceDelete();
    }
}
