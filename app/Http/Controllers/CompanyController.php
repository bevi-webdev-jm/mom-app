<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

use App\Http\Requests\CompanyAddRequest;
use App\Http\Requests\CompanyEditRequest;

use App\Http\Traits\SettingTrait;

/**
 * Class CompanyController
 * 
 * Controller to handle CRUD operations for Company model.
 * Provides methods to list, create, show, edit, and update companies.
 */
class CompanyController extends Controller
{
    use SettingTrait;

    /**
     * Display a paginated list of companies with optional search filtering.
     *
     * @param Request $request HTTP request object containing search query.
     * @return \Illuminate\View\View View displaying the list of companies.
     */
    public function index(Request $request) {

        // Trim and get search query parameter
        $search = trim($request->get('search'));
        
        // Query companies ordered by creation date descending
        $companies = Company::orderBy('created_at', 'DESC')
            // Apply search filter if search query is not empty
            ->when(!empty($search), function($query) use($search) {
                $query->where('name', 'like', '%'.$search.'%');
            })
            // Paginate results with configurable items per page
            ->paginate($this->getDataPerPage())
            // Append query parameters to pagination links
            ->appends(request()->query());

        // Return the companies index view with search and companies data
        return view('pages.companies.index')->with([
            'search' => $search,
            'companies' => $companies
        ]);
    }

    /**
     * Show the form for creating a new company.
     *
     * @return \Illuminate\View\View View displaying the create company form.
     */
    public function create() {
        return view('pages.companies.create');
    }

    /**
     * Store a newly created company in the database.
     *
     * @param CompanyAddRequest $request Validated request containing company data.
     * @return \Illuminate\Http\RedirectResponse Redirect to the companies index with success message.
     */
    public function store(CompanyAddRequest $request) {

        // Create new company instance with name from request
        $company = new Company([
            'name' => $request->name
        ]);
        $company->save();

        // Log the creation activity
        activity('created')
            ->performedOn($company)
            ->log(':causer.name has created company :subject.name');

        // Redirect to company index with success message
        return redirect()->route('company.index')->with([
            'message_success' => __('adminlte::companies.company_create_success')
        ]);
    }

    /**
     * Display the specified company details.
     *
     * @param string $id Encrypted company ID.
     * @return \Illuminate\View\View View displaying the company details.
     */
    public function show($id) {
        $company = Company::findOrFail(decrypt($id));

        return view('pages.companies.show')->with([
            'company' => $company
        ]);
    }

    /**
     * Show the form for editing the specified company.
     *
     * @param string $id Encrypted company ID.
     * @return \Illuminate\View\View View displaying the edit company form.
     */
    public function edit($id) {
        $company = Company::findOrFail(decrypt($id));

        return view('pages.companies.edit')->with([
            'company' => $company
        ]);
    }

    /**
     * Update the specified company in the database.
     *
     * @param CompanyEditRequest $request Validated request containing updated company data.
     * @param string $id Encrypted company ID.
     * @return \Illuminate\Http\RedirectResponse Redirect back with success message.
     */
    public function update(CompanyEditRequest $request, $id) {
        $company = Company::findOrFail(decrypt($id));

        // Store original attributes before update for logging
        $changes_arr['old'] = $company->getOriginal();

        // Update company name from request
        $company->update([
            'name' => $request->name
        ]);
        $company->save();

        // Store changed attributes for logging
        $changes_arr['changes'] = $company->getChanges();

        // Log the update activity with changes
        activity('updated')
            ->performedOn($company)
            ->withProperties($changes_arr)
            ->log(':causer.name has updated company :subject.name');

        // Redirect back with success message
        return back()->with([
            'message_success' => __('adminlte::companies.company_update_success')
        ]);
    }
}
