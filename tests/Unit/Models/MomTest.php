<?php

namespace Tests\Unit\Models;

use App\Models\Mom;
use App\Models\MomDetail;
use App\Models\MomType;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class MomTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $mom = new Mom();
        $expectedFillable = [
            'mom_type_id',
            'user_id',
            'mom_number',
            'agenda',
            'meeting_date',
            'status',
        ];
        $this->assertEquals($expectedFillable, $mom->getFillable());
    }

    /** @test */
    public function it_uses_connection_from_session_if_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('tenant_db');
        $mom = new Mom();
        $this->assertEquals('tenant_db', $mom->getConnectionName());
    }

    /** @test */
    public function it_uses_default_connection_if_session_not_set()
    {
        Session::shouldReceive('get')->with('db_connection', 'mysql')->andReturn('mysql');
        $mom = new Mom();
        $this->assertEquals('mysql', $mom->getConnectionName());
    }

    /** @test */
    public function it_belongs_to_a_type()
    {
        $mom = new Mom();
        $relation = $mom->type();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(MomType::class, $relation->getRelated());
    }

    /** @test */
    public function it_has_many_details()
    {
        $mom = new Mom();
        $relation = $mom->details();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(MomDetail::class, $relation->getRelated());
    }

    /** @test */
    public function it_belongs_to_many_participants()
    {
        $mom = new Mom();
        $relation = $mom->participants();
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
        $this->assertEquals('mom_participants', $relation->getTable());
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $mom = new Mom();
        $relation = $mom->user();
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
    }
}