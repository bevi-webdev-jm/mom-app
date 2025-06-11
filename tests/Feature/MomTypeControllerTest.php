<?php

namespace Tests\Feature;

use App\Models\MomType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Permission;
use Tests\TestCase;

class MomTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $basicUser;

    const PERMISSION_TYPE_ACCESS = 'type access';
    const PERMISSION_TYPE_CREATE = 'type create';
    const PERMISSION_TYPE_EDIT = 'type edit';

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        Permission::findOrCreate(self::PERMISSION_TYPE_ACCESS, 'web');
        Permission::findOrCreate(self::PERMISSION_TYPE_CREATE, 'web');
        Permission::findOrCreate(self::PERMISSION_TYPE_EDIT, 'web');

        $this->adminUser = User::factory()->create();
        $this->basicUser = User::factory()->create();

        $this->adminUser->givePermissionTo([
            self::PERMISSION_TYPE_ACCESS,
            self::PERMISSION_TYPE_CREATE,
            self::PERMISSION_TYPE_EDIT,
        ]);
    }

    /** @test */
    public function authorized_user_can_view_mom_types_index()
    {
        MomType::factory(3)->create();
        $this->actingAs($this->adminUser)
            ->get(route('type.index'))
            ->assertStatus(200)
            ->assertViewIs('pages.types.index') // Assuming this view name
            ->assertViewHas('types'); // Or your specific variable name
    }

    /** @test */
    public function unauthorized_user_cannot_view_mom_types_index()
    {
        $this->actingAs($this->basicUser)
            ->get(route('type.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_create_mom_type_page()
    {
        $this->actingAs($this->adminUser)
            ->get(route('type.create'))
            ->assertStatus(200)
            ->assertViewIs('pages.types.create'); // Assuming this view name
    }

    /** @test */
    public function authorized_user_can_store_a_new_mom_type()
    {
        $momTypeData = ['type' => 'Weekly Meeting'];

        $this->actingAs($this->adminUser)
            ->post(route('type.store'), $momTypeData)
            ->assertRedirect(route('type.index')) // Or your specific redirect
            ->assertSessionHas('message_success');

        $this->assertDatabaseHas('mom_types', $momTypeData);
    }

    /** @test */
    public function store_mom_type_requires_type_field()
    {
        $this->actingAs($this->adminUser)
            ->post(route('type.store'), ['type' => ''])
            ->assertSessionHasErrors('type');
        $this->assertDatabaseCount('mom_types', 0);
    }

    /** @test */
    public function unauthorized_user_cannot_store_mom_type()
    {
        $this->actingAs($this->basicUser)
            ->post(route('type.store'), ['type' => 'Secret Type'])
            ->assertStatus(403);
        $this->assertDatabaseMissing('mom_types', ['type' => 'Secret Type']);
    }


    /** @test */
    public function authorized_user_can_view_a_mom_type()
    {
        $momType = MomType::factory()->create();
        $this->actingAs($this->adminUser)
            ->get(route('type.show', encrypt($momType->id)))
            ->assertStatus(200)
            ->assertViewIs('pages.types.show') // Assuming this view name
            ->assertViewHas('mom_type', $momType);
    }

    /** @test */
    public function authorized_user_can_view_edit_mom_type_page()
    {
        $momType = MomType::factory()->create();
        $this->actingAs($this->adminUser)
            ->get(route('type.edit', encrypt($momType->id)))
            ->assertStatus(200)
            ->assertViewIs('pages.types.edit') // Assuming this view name
            ->assertViewHas('type', $momType);
    }

    /** @test */
    public function unauthorized_user_cannot_view_edit_mom_type_page()
    {
        $momType = MomType::factory()->create();
        $this->basicUser->givePermissionTo(self::PERMISSION_TYPE_ACCESS); // Can view index/show

        $this->actingAs($this->basicUser)
            ->get(route('type.edit', encrypt($momType->id)))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_a_mom_type()
    {
        $momType = MomType::factory()->create(['type' => 'Old Type']);
        $updatedData = ['type' => 'Updated Meeting Type'];

        $this->actingAs($this->adminUser)
            ->post(route('type.update', encrypt($momType->id)), $updatedData) // Using POST as per your routes
            ->assertSessionHas('message_success');

        $this->assertDatabaseHas('mom_types', array_merge(['id' => $momType->id], $updatedData));
        $this->assertDatabaseMissing('mom_types', ['type' => 'Old Type']);
    }

    /** @test */
    public function update_mom_type_requires_type_field()
    {
        $momType = MomType::factory()->create();
        $this->actingAs($this->adminUser)
            ->post(route('type.update', encrypt($momType->id)), ['type' => ''])
            ->assertSessionHasErrors('type');

        $this->assertEquals($momType->type, $momType->fresh()->type);
    }

    /** @test */
    public function unauthorized_user_cannot_update_mom_type()
    {
        $momType = MomType::factory()->create(['type' => 'Original Type']);
        $this->basicUser->givePermissionTo(self::PERMISSION_TYPE_ACCESS); // Can view index/show

        $this->actingAs($this->basicUser)
            ->post(route('type.update', encrypt($momType->id)), ['type' => 'Attempted Update'])
            ->assertStatus(403);

        $this->assertDatabaseHas('mom_types', ['type' => 'Original Type']);
    }
}