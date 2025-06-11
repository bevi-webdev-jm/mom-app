<?php

namespace Tests\Unit\Models;

use App\Models\MomType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class MomTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $momType = new MomType();
        $expectedFillable = [
            'type',
        ];
        $this->assertEquals($expectedFillable, $momType->getFillable());
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $momType = new MomType();
        $this->assertEquals('tenant_db', $momType->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $momType = new MomType();
        $this->assertEquals('mysql', $momType->getConnectionName());
    }
}