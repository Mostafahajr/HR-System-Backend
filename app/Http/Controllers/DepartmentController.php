<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // GET all departments
    public function index()
    {
        $departments = Department::all();
        return DepartmentResource::collection($departments);
    }

    // POST create a new department
    public function store(StoreDepartmentRequest $request)
    {
        $validatedData = $request->validated();
        $department = Department::create($validatedData);

        return new DepartmentResource($department);
    }

    // GET single department
    public function show($id)
    {
        $department = Department::findOrFail($id);
        return new DepartmentResource($department);
    }

    // PUT update an existing department
    public function update(UpdateDepartmentRequest $request, $id)
    {
        $department = Department::findOrFail($id);

        $validatedData = $request->validated();
        $department->update($validatedData);

        return new DepartmentResource($department);
    }

    // DELETE a department
    public function destroy($id)
    {
        Department::findOrFail($id)->delete();

        return response()->json(['message' => 'Department deleted successfully']);
    }
}
