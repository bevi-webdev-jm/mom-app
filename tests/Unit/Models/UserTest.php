<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Company; // Assuming Company model exists for the relationship
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Required for Spatie/laravel-permission
        $permissionRegistrar = $this->app->make(\Spatie\Permission\PermissionRegistrar::class);
        $permissionRegistrar->registerPermissions($this->app->make(Gate::class));

        // Seed a default role if your tests rely on it for adminlte_desc
        Role::findOrCreate('user', 'web');
    }

    /** @test */
    public function it_hashes_password_on_creation()
    {
        $user = User::factory()->create(['password' => 'password123']);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $user = new User();
        $this->assertEquals('tenant_db', $user->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $user = new User();
        $this->assertEquals('mysql', $user->getConnectionName());
    }

    /** @test */
    public function is_online_returns_true_for_recent_activity()
    {
        $user = new User(['last_activity' => now()->subMinute()]);
        $this->assertTrue($user->isOnline());
    }

    /** @test */
    public function is_online_returns_false_for_stale_activity()
    {
        $user = new User(['last_activity' => now()->subMinutes(5)]);
        $this->assertFalse($user->isOnline());
    }

    /** @test */
    public function is_online_returns_false_if_last_activity_is_null()
    {
        $user = new User(['last_activity' => null]);
        $this->assertFalse($user->isOnline());
    }

    /** @test */
    public function adminlte_image_returns_profile_pic_url_if_set()
    {
        $user = new User(['profile_pic' => 'path/to/image.jpg']);
        $this->assertEquals(asset('path/to/image.jpg'), $user->adminlte_image());
    }

    /** @test */
    public function adminlte_image_returns_default_url_if_profile_pic_is_not_set()
    {
        $user = new User(['profile_pic' => null]);
        $this->assertEquals(asset('images/Default_pfp.svg.png'), $user->adminlte_image());
    }

    /** @test */
    public function adminlte_desc_returns_role_names_string()
    {
        $user = User::factory()->create();
        $role1 = Role::findOrCreate('editor', 'web');
        $role2 = Role::findOrCreate('viewer', 'web');
        $user->assignRole($role1, $role2);

        $this->assertEquals('editor, viewer', $user->adminlte_desc());
    }

    /** @test */
    public function adminlte_desc_returns_hyphen_if_no_roles()
    {
        $user = User::factory()->create(); // User has no roles by default after creation
        // Or ensure no roles: $user->syncRoles([]);
        $this->assertEquals('-', $user->adminlte_desc());
    }

    /** @test */
    public function adminlte_profile_url_is_correct()
    {
        $user = User::factory()->create(['id' => 123]);
        // We don't want to test the actual encryption, just that it's called and structure is right
        // For a more isolated test, you could mock `encrypt()`
        $this->assertStringStartsWith('profile/', $user->adminlte_profile_url());
    }

    // You can also add tests for relationships like company() and moms()
    // e.g., test_user_belongs_to_company(), test_user_belongs_to_many_moms()
}