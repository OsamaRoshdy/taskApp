<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Contracts\Pagination\Paginator;

class UserTest extends TestCase
{
    use WithFaker;

    public function test_can_list_users()
    {
        $response = $this->actingAsWithRole()->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertViewHas('users');
        $this->assertInstanceOf(Paginator::class, $response->viewData('users'));
    }

    public function test_can_create_user()
    {
        $this->followingRedirects()
            ->actingAsWithRole()
            ->post(route('users.store'), $this->fakeData())
            ->assertStatus(200)
            ->assertViewHas('users');
    }

    public function test_can_edit_user()
    {
        $user = User::factory()->create();
        $this->followingRedirects()
            ->actingAsWithRole()
            ->patch(route('users.update', $user->id), $this->fakeData())
            ->assertStatus(200)
            ->assertViewHas('users');
    }

    public function test_can_show_user()
    {
        $user = User::factory()->create();
        $this->followingRedirects()
            ->actingAsWithRole()
            ->get(route('users.show', $user->id))
            ->assertStatus(200)
            ->assertViewHas('user');
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();
        $this->followingRedirects()
            ->actingAsWithRole()
            ->delete(route('users.destroy', $user->id))
            ->assertStatus(200)
            ->assertViewHas('users');
    }


}
