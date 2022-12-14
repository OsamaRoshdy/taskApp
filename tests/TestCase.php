<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker;

    protected function actingAsWithRole($role = 'admin')
    {
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['name' => $role]);
        $user->roles()->sync([$role->id]);
        return $this->actingAs($user);
    }

    public function fakeData()
    {
        $role = Role::factory()->create();
        return [
            'firstname' => $this->faker->name,
            'lastname' => $this->faker->name,
            'username' => $this->faker->userName,
            'password' => 12345678,
            'password_confirmation' => 12345678,
            'email' => $this->faker->email,
            'roles' => $role->id,
            'photo' => UploadedFile::fake()->image('avatar.jpg')
        ];
    }
}
