<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::paginate(3);
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|dimensions:min_width=100,min_height=100',
        ]);
    
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('/public/logos');
            $data['logo'] = str_replace('public/', '', $path);
        }

        Company::create($data);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('/public/logos');
            $data['logo'] = str_replace('public/', '', $path);
        }

        $company->update($data);

            // Set a success message
            session()->flash('message', 'Update successful!');
            session()->flash('type', 'success'); // Optional: customize the alert type


        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
    // Delete the company's logo from storage if it exists
    if ($company->logo) {
        Storage::delete($company->logo);
    }

    // Delete the company record
    $company->delete();

    // Redirect back to the companies index with a success message
    return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
