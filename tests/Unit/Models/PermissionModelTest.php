<?php

namespace Tests\Unit\Models;

use App\Models\Permission as CustomPermission; // Your custom Permission model
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Tests\TestCase;

class PermissionModelTest extends TestCase // Renamed to avoid conflict
{
    use RefreshDatabase;

    /** @test */
    public function it_is_an_instance_of_spatie_permission()
    {
        $this->assertInstanceOf(SpatiePermission::class, new CustomPermission());
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $permission = new CustomPermission();
        $this->assertEquals('tenant_db', $permission->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $permission = new CustomPermission();
        $this->assertEquals('mysql', $permission->getConnectionName());
    }
}