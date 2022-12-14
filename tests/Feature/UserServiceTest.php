<?php

namespace Tests\Feature;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;
    protected UserService $userService;

    public function setUp() :void
    {
        $this->userService = resolve('App\Services\UserService');
        parent::setUp();
    }

    public function test_it_can_return_a_paginated_list_of_users()
    {
        $data = $this->userService->list();
        $this->assertInstanceOf(Paginator::class, $data);
    }

    public function test_it_can_store_a_user_to_database()
    {
        $user = $this->userService->store($this->fakeData());
        $this->assertInstanceOf(User::class, $user);
    }

    public function test_it_can_find_and_return_an_existing_user()
    {
        $oldUser = User::factory()->create();
        $user = $this->userService->find($oldUser->id);
        $this->assertInstanceOf(User::class, $user);
    }

    public function test_it_can_update_an_existing_user()
    {
        $oldUser = User::factory()->create();
        $user = $this->userService->update($oldUser->id, $this->fakeData());
        $this->assertInstanceOf(User::class, $user);
    }

    public function test_it_can_soft_delete_an_existing_user()
    {
        $oldUser = User::factory()->create();
        $this->userService->destroy($oldUser->id);
        $user = $this->userService->findTrashed($oldUser->id);
        $this->assertInstanceOf(User::class, $user);
    }

    public function test_it_can_return_a_paginated_list_of_trashed_users()
    {
        $users = $this->userService->listTrashed();
        $this->assertInstanceOf(Paginator::class, $users);
    }

    public function test_it_can_restore_a_soft_deleted_user()
    {
        $user = User::factory()->create();
        $this->userService->destroy($user->id);
        $this->userService->restore($user->id);
        $this->assertInstanceOf(User::class, $this->userService->find($user->id));
    }

    public function test_it_can_permanently_delete_a_soft_deleted_user()
    {
        $oldUser = User::factory()->create();
        $this->userService->delete($oldUser->id);
        $user = User::find($oldUser->id);
        $this->assertNull($user);
    }
}
