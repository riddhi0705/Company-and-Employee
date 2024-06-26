<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $keyword = $request->get('query');
            $employees = Employee::where('first_name', 'LIKE', "%$keyword%")
                                 ->orWhere('last_name', 'LIKE', "%$keyword%")
                                 ->with('company') // Ensure you have the company relationship
                                 ->get();
    
            return response()->json([
                'view' => view('partials.employees_list', compact('employees'))->render(),
            ]);
        } else {
            $employees = Employee::with('company')->paginate(10);
            return view('employees.index', compact('employees'));
        }
    
        // Your existing code to display the page initially
        $employees = Employee::with('company')->paginate(2);
        $companies = Company::all();
        return view('employees.index', compact('employees','companies'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all(); // Fetch all companies for the dropdown
        return view('employees.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $companies = Company::all();
        return view('employees.edit', compact('employee', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
