<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Permission;
use App\Models\Role;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $basicUser;

    // Define permission names as constants or properties for consistency
    const PERMISSION_COMPANY_ACCESS = 'company access';
    const PERMISSION_COMPANY_CREATE = 'company create';
    const PERMISSION_COMPANY_EDIT = 'company edit';

    protected function setUp(): void
    {
        parent::setUp();

        // Clear cached permissions
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Create permissions
        Permission::findOrCreate(self::PERMISSION_COMPANY_ACCESS, 'web');
        Permission::findOrCreate(self::PERMISSION_COMPANY_CREATE, 'web');
        Permission::findOrCreate(self::PERMISSION_COMPANY_EDIT, 'web');

        // Create users
        $this->adminUser = User::factory()->create();
        $this->basicUser = User::factory()->create(); // A user with no specific company permissions initially

        // Assign permissions to admin user (or a role)
        $this->adminUser->givePermissionTo([
            self::PERMISSION_COMPANY_ACCESS,
            self::PERMISSION_COMPANY_CREATE,
            self::PERMISSION_COMPANY_EDIT,
        ]);
    }

    /** @test */
    public function authorized_user_can_view_companies_index()
    {
        Company::factory(3)->create();
        $this->actingAs($this->adminUser)
            ->get(route('company.index'))
            ->assertStatus(200)
            ->assertViewIs('pages.companies.index') // Assuming this view name
            ->assertViewHas('companies');
    }

    /** @test */
    public function unauthorized_user_cannot_view_companies_index()
    {
        $this->actingAs($this->basicUser)
            ->get(route('company.index'))
            ->assertStatus(403); // Forbidden
    }

    /** @test */
    public function authorized_user_can_view_create_company_page()
    {
        $this->actingAs($this->adminUser)
            ->get(route('company.create'))
            ->assertStatus(200)
            ->assertViewIs('pages.companies.create'); // Assuming this view name
    }

    /** @test */
    public function unauthorized_user_cannot_view_create_company_page()
    {
        $this->actingAs($this->basicUser)
            ->get(route('company.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_store_a_new_company()
    {
        $companyData = ['name' => 'New Test Company'];

        $this->actingAs($this->adminUser)
            ->post(route('company.store'), $companyData)
            ->assertRedirect(route('company.index')) // Or wherever your controller redirects
            ->assertSessionHas('message_success'); // Or your specific success message key

        $this->assertDatabaseHas('companies', $companyData);
    }

    /** @test */
    public function store_company_requires_a_name()
    {
        $this->actingAs($this->adminUser)
            ->post(route('company.store'), ['name' => ''])
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('companies', 0);
    }

    /** @test */
    public function unauthorized_user_cannot_store_a_new_company()
    {
        $companyData = ['name' => 'Unauthorized Company'];
        $this->actingAs($this->basicUser)
            ->post(route('company.store'), $companyData)
            ->assertStatus(403);

        $this->assertDatabaseMissing('companies', $companyData);
    }

    /** @test */
    public function authorized_user_can_view_a_company()
    {
        $company = Company::factory()->create();
        $this->actingAs($this->adminUser)
            ->get(route('company.show', encrypt($company->id)))
            ->assertStatus(200)
            ->assertViewIs('pages.companies.show') // Assuming this view name
            ->assertViewHas('company', $company);
    }

    /** @test */
    public function unauthorized_user_cannot_view_a_company()
    {
        $company = Company::factory()->create();
        // Give basic user only access permission to test show specifically
        $this->basicUser->givePermissionTo(self::PERMISSION_COMPANY_ACCESS);
        $this->basicUser->revokePermissionTo(self::PERMISSION_COMPANY_EDIT); // Ensure no edit

        $this->actingAs($this->basicUser)
            ->get(route('company.show', encrypt($company->id)))
            ->assertStatus(200); // Show might be allowed if 'company access' is granted

        // Test a user with absolutely no 'company access' permission
        $noAccessUser = User::factory()->create();
         $this->actingAs($noAccessUser)
            ->get(route('company.show', encrypt($company->id)))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_view_edit_company_page()
    {
        $company = Company::factory()->create();
        $this->actingAs($this->adminUser)
            ->get(route('company.edit', encrypt($company->id)))
            ->assertStatus(200)
            ->assertViewIs('pages.companies.edit') // Assuming this view name
            ->assertViewHas('company', $company);
    }

    /** @test */
    public function unauthorized_user_cannot_view_edit_company_page()
    {
        $company = Company::factory()->create();
        $this->basicUser->givePermissionTo(self::PERMISSION_COMPANY_ACCESS); // Can view index/show
        $this->actingAs($this->basicUser)
            ->get(route('company.edit', encrypt($company->id)))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_a_company()
    {
        $company = Company::factory()->create(['name' => 'Old Name']);
        $updatedData = ['name' => 'Updated Company Name'];

        $this->actingAs($this->adminUser)
            ->post(route('company.update', encrypt($company->id)), $updatedData) // Using POST as per your routes for update
            ->assertSessionHas('message_success');

        $this->assertDatabaseHas('companies', array_merge(['id' => $company->id], $updatedData));
        $this->assertDatabaseMissing('companies', ['name' => 'Old Name']);
    }

    /** @test */
    public function update_company_requires_a_name()
    {
        $company = Company::factory()->create();
        $this->actingAs($this->adminUser)
            ->post(route('company.update', encrypt($company->id)), ['name' => ''])
            ->assertSessionHasErrors('name');

        $this->assertEquals($company->name, $company->fresh()->name); // Name should not have changed
    }

    /** @test */
    public function unauthorized_user_cannot_update_a_company()
    {
        $company = Company::factory()->create(['name' => 'Original Name']);
        $updatedData = ['name' => 'Attempted Update'];

        $this->basicUser->givePermissionTo(self::PERMISSION_COMPANY_ACCESS); // Can view index/show
        $this->actingAs($this->basicUser)
            ->post(route('company.update', encrypt($company->id)), $updatedData)
            ->assertStatus(403);

        $this->assertDatabaseHas('companies', ['name' => 'Original Name']);
    }
}