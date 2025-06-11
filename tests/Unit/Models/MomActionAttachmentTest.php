<?php

namespace Tests\Unit\Models;

use App\Models\MomAction;
use App\Models\MomActionAttachment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class MomActionAttachmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $attachment = new MomActionAttachment();
        $expectedFillable = [
            'mom_action_id',
            'path',
            'remarks',
        ];
        $this->assertEquals($expectedFillable, $attachment->getFillable());
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $attachment = new MomActionAttachment();
        $this->assertEquals('tenant_db', $attachment->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $attachment = new MomActionAttachment();
        $this->assertEquals('mysql', $attachment->getConnectionName());
    }

    /** @test */
    public function it_belongs_to_an_action()
    {
        $attachment = new MomActionAttachment();
        $relation = $attachment->action();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(MomAction::class, $relation->getRelated());
    }
}