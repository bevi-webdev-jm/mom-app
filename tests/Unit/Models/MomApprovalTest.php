<?php

namespace Tests\Unit\Models;

use App\Models\Mom;
use App\Models\MomApproval;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class MomApprovalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $approval = new MomApproval();
        $expectedFillable = [
            'mom_id',
            'user_id',
            'status',
            'remarks',
        ];
        $this->assertEquals($expectedFillable, $approval->getFillable());
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $approval = new MomApproval();
        $this->assertEquals('tenant_db', $approval->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $approval = new MomApproval();
        $this->assertEquals('mysql', $approval->getConnectionName());
    }

    /** @test */
    public function it_belongs_to_a_mom()
    {
        $approval = new MomApproval();
        $relation = $approval->mom();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(Mom::class, $relation->getRelated());
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $approval = new MomApproval();
        $relation = $approval->user();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
    }
}