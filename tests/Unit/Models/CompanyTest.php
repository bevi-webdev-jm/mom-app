<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $company = new Company();
        $expectedFillable = [
            'name',
        ];
        $this->assertEquals($expectedFillable, $company->getFillable());
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $company = new Company();
        $this->assertEquals('tenant_db', $company->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $company = new Company();
        $this->assertEquals('mysql', $company->getConnectionName());
    }

    /** @test */
    public function it_has_many_users()
    {
        $company = new Company();
        $relation = $company->users();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
    }
}