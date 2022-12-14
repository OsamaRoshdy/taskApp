<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ImageUploaderTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserService implements UserServiceInterface
{
    use ImageUploaderTrait;

    protected User $model;

    protected Request $request;

    public function __construct(User $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    public function rules($id = null)
    {
        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'roles' => 'required',
            'username' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'min:8|' . request()->method() === 'POST' ? 'required' : 'sometimes',
            'photo' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:10000'
        ];
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

    public function findTrashed(int $id):? Model
    {
        return $this->model::withTrashed()->findOrFail($id);
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
        return $this->model::onlyTrashed()->select(['id', 'firstname', 'lastname', 'username', 'email'])->paginate(10);
    }

    public function restore($id)
    {
        return $this->findTrashed($id)->restore();
    }

    public function delete($id)
    {
        $user = $this->findTrashed($id);
        $this->deleteImage($user->photo, 'users');
        return $user->forceDelete();
    }

    public function hash(string $key): string
    {
        return bcrypt($key);
    }

}
