<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $attends = Attendance::get();
        return AttendanceResource::collection($attends);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(AttendanceRequest $request)
    // {
    //     //
    //     $valdiatedAttend = $request->validated();
    //     $attend = Attendance::create($valdiatedAttend);

    //     return new AttendanceResource($attend);
    // }

    /**
     * Display the specified resource.
     */
    // public function show($id)
    // {
    //     //
    //     $attend = Attendance::findOrFail($id);
    //     return new AttendanceResource($attend);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttendanceRequest $request,$id)
    {
        //
        $attend = Attendance::findOrFail($id);
        $valdiatedAttend = $request->validated();
        
        $attend->update($valdiatedAttend);

        return new AttendanceResource($attend);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $attend = Attendance::findOrfail($id);
        $attend->delete();
        return response()->json(['message' => 'Admin deleted successfully']);
    }
}
