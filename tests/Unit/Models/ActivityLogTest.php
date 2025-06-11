<?php

namespace Tests\Unit\Models;

use App\Models\Activity; // Your custom Activity model
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ActivityLogTest extends TestCase // Renamed to avoid conflict if Spatie has ActivityTest
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $activity = new Activity();
        $this->assertEquals('tenant_db', $activity->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $activity = new Activity();
        $this->assertEquals('mysql', $activity->getConnectionName());
    }
}