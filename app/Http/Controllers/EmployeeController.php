<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department')->get(); // Eager load the department relationship
        return EmployeeResource::collection($employees);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $validatedData = $request->validated();
        $employee = Employee::create($validatedData);
        return new EmployeeResource($employee);
    }
    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        $validatedData = $request->validated(); // Use validated() method for the validated data
        $employee->update($validatedData);
        return new EmployeeResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Employee::findOrFail($id)->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
