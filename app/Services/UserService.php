<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ImageUploaderTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class UserService implements UserServiceInterface
{
    use ImageUploaderTrait;

    protected Model $model;

    protected Request $request;

    public function __construct(User $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    public function list()
    {
        return $this->model->select(['id', 'firstname', 'lastname', 'username', 'email', 'photo'])->paginate(10);
    }


    public function store(array $attributes)
    {
        $data = $attributes;
        $data['password'] = $this->hash($attributes['password']);
        $data['photo'] = $this->storeImage($attributes['photo'], 'users');
        $user = $this->model->create($data);
        $user->roles()->sync([$attributes['roles']]);
        return $user;
    }

    public function find(int $id):? Model
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $attributes)
    {

        $data = collect($attributes)->except(['password', 'photo'])->toArray();
        $user = $this->find($id);
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
        return $this->find($id)->delete();
    }

    public function listTrashed()
    {
        return $this->model->onlyTrashed()->select(['id', 'firstname', 'lastname', 'username', 'email'])->paginate(10);
    }

    public function restore($id)
    {
        return $this->model->where('id', $id)->withTrashed()->restore();
    }

    public function delete($id)
    {
        $user = $this->model->where('id', $id)->withTrashed()->first();
        $this->deleteImage($user->photo, 'users');
        return $user->forceDelete();
    }

    public function hash(string $key): string
    {
        return bcrypt($key);
    }

}
