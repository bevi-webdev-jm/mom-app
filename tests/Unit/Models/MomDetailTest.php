<?php

namespace Tests\Unit\Models;

use App\Models\Mom;
use App\Models\MomAction;
use App\Models\MomDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class MomDetailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $detail = new MomDetail();
        $expectedFillable = [
            'mom_id',
            'topic',
            'next_step',
            'target_date',
            'completed_date',
            'remarks',
            'status',
        ];
        $this->assertEquals($expectedFillable, $detail->getFillable());
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $detail = new MomDetail();
        $this->assertEquals('tenant_db', $detail->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $detail = new MomDetail();
        $this->assertEquals('mysql', $detail->getConnectionName());
    }

    /** @test */
    public function it_belongs_to_a_mom()
    {
        $detail = new MomDetail();
        $relation = $detail->mom();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(Mom::class, $relation->getRelated());
    }

    /** @test */
    public function it_has_many_actions()
    {
        $detail = new MomDetail();
        $relation = $detail->actions();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(MomAction::class, $relation->getRelated());
    }

    /** @test */
    public function it_belongs_to_many_responsibles()
    {
        $detail = new MomDetail();
        $relation = $detail->responsibles();
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
        $this->assertEquals('mom_responsibles', $relation->getTable());
    }
}