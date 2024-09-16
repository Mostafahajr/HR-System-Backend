<?php

namespace App\Http\Controllers;

use App\Http\Resources\PrivilegeCollection;
use App\Models\GroupPrivilege;
use App\Models\GroupType;
use App\Models\Privilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionsController extends Controller
{
    public function index() {
        $privileges = Privilege::all();
        return new PrivilegeCollection($privileges);
    }

    public function store(Request $request) {
        Log::info('Received request data: ' . json_encode($request->all()));

        try {
            $validatedData = $request->validate([
                'group_name' => 'required|string|max:255',
                'privileges' => 'required|array',
                'privileges.*' => 'exists:privileges,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ' . json_encode($e->errors()));
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $groupType = GroupType::create([
                'group_name' => $validatedData['group_name'],
            ]);

            foreach ($validatedData['privileges'] as $privilegeId) {
                GroupPrivilege::create([
                    'group_type_id' => $groupType->id,
                    'privilege_id' => $privilegeId,
                ]);
            }

            DB::commit();

            $response = [
                'message' => 'Group and privileges created successfully',
                'group' => $groupType,
            ];
            Log::info('Response data: ' . json_encode($response));
            return response()->json($response, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in store method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'message' => 'An error occurred while creating the group and privileges',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function show($id)
    {
        try {
            $groupType = GroupType::with('privileges')->findOrFail($id);
            $allPrivileges = Privilege::all();

            $groupedPrivileges = $allPrivileges->groupBy('page_name')->map(function ($privileges) use ($groupType) {
                return $privileges->map(function ($privilege) use ($groupType) {
                    return [
                        'id' => $privilege->id,
                        'operation' => $privilege->operation,
                        'is_selected' => $groupType->privileges->contains($privilege->id)
                    ];
                });
            });
            return response()->json([
                'group' => $groupType,
                'privileges' => $groupedPrivileges
            ]);
        } catch (\Exception $e) {
            Log::error('Error in show method: ' . $e->getMessage());
            return response()->json([
                'message' => 'An error occurred while fetching the group',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

public function update(Request $request, $id)
{
    Log::info('Received update request data: ' . json_encode($request->all()));

    try {
        $validatedData = $request->validate([
            'group_name' => 'required|string|max:255',
            'privileges' => 'required|array',
            'privileges.*' => 'exists:privileges,id',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation failed: ' . json_encode($e->errors()));
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    }

    DB::beginTransaction();

    try {
        $groupType = GroupType::findOrFail($id);
        $groupType->update([
            'group_name' => $validatedData['group_name'],
        ]);

        // Remove all existing privileges
        $groupType->privileges()->detach();

        // Add new privileges
        $groupType->privileges()->attach($validatedData['privileges']);

        DB::commit();

        $response = [
            'message' => 'Group and privileges updated successfully',
            'group' => $groupType->fresh('privileges'),
        ];
        Log::info('Response data: ' . json_encode($response));
        return response()->json($response);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error in update method: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        return response()->json([
            'message' => 'An error occurred while updating the group and privileges',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
