<?php

namespace Tests\Unit\Models;

use App\Models\SystemSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class SystemSettingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $setting = new SystemSetting();
        $expectedFillable = [
            'data_per_page',
            'email_sending',
            'alarm_on',
        ];
        $this->assertEquals($expectedFillable, $setting->getFillable());
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $setting = new SystemSetting();
        $this->assertEquals('tenant_db', $setting->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $setting = new SystemSetting();
        $this->assertEquals('mysql', $setting->getConnectionName());
    }
}