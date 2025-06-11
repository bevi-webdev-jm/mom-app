<?php

namespace Tests\Unit\Models;

use App\Models\MomAction;
use App\Models\MomActionAttachment;
use App\Models\MomDetail;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class MomActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $momAction = new MomAction();
        $expectedFillable = [
            'mom_detail_id',
            'user_id',
            'action_taken',
            'remarks',
        ];
        $this->assertEquals($expectedFillable, $momAction->getFillable());
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $momAction = new MomAction();
        $this->assertEquals('tenant_db', $momAction->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $momAction = new MomAction();
        $this->assertEquals('mysql', $momAction->getConnectionName());
    }

    /** @test */
    public function it_belongs_to_a_detail()
    {
        $momAction = new MomAction();
        $relation = $momAction->detail();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(MomDetail::class, $relation->getRelated());
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $momAction = new MomAction();
        $relation = $momAction->user();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
    }

    /** @test */
    public function it_has_many_attachments()
    {
        $momAction = new MomAction();
        $relation = $momAction->attachments();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(MomActionAttachment::class, $relation->getRelated());
    }
}