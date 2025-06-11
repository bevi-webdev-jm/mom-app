<?php

namespace Tests\Unit\Models;

use App\Models\Role as CustomRole; // Your custom Role model
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role as SpatieRole;
use Tests\TestCase;

class RoleModelTest extends TestCase // Renamed to avoid conflict with Spatie's own tests if any
{
    use RefreshDatabase;

    /** @test */
    public function it_is_an_instance_of_spatie_role()
    {
        $this->assertInstanceOf(SpatieRole::class, new CustomRole());
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $role = new CustomRole();
        $this->assertEquals('tenant_db', $role->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $role = new CustomRole();
        $this->assertEquals('mysql', $role->getConnectionName());
    }
}