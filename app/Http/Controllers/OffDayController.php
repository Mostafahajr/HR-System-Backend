<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreOffDayRequest;
use App\Http\Requests\UpdateOffDayRequest;
use App\Http\Resources\OffDayResource;
use App\Models\OffDay;
use App\Models\OffDayType;
use Illuminate\Http\Request;

class OffDayController extends Controller
{
    // GET all off days
    public function index()
    {
        $offDays = OffDay::with('offDayTypes')->get();
        return OffDayResource::collection($offDays);
    }

    // POST create a new off day
    public function store(StoreOffDayRequest $request)
    {
        $validatedData = $request->validated();
        // Create the off day
        $offDay = OffDay::create($validatedData);
        
        // Find or create the 'holiday' type
        $holidayType = OffDayType::firstOrCreate(
            ['name' => 'holiday'],
            ['description' => 'Default holiday type']
        );

        // Attach the holiday type to the off day
        $offDay->offDayTypes()->attach($holidayType->id);

        return new OffDayResource($offDay);
    }

    // GET single off day
    public function show($id)
    {
        $offDay = OffDay::with('offDayTypes')->findOrFail($id);
        return new OffDayResource($offDay);
    }

    // PUT update an existing off day
    public function update(UpdateOffDayRequest $request, $id)
    {
        $offDay = OffDay::findOrFail($id);
        $validatedData = $request->validated();
        $offDay->update($validatedData);

        // Ensure the 'holiday' type is still associated
        $holidayType = OffDayType::firstOrCreate(
            ['name' => 'holiday'],
            ['description' => 'Default holiday type']
        );

        // Sync the off day types (this will ensure only 'holiday' type is associated)
        $offDay->offDayTypes()->sync([$holidayType->id]);

        return new OffDayResource($offDay);
    }

    // DELETE an off day
    public function destroy($id)
    {
        $offDay = OffDay::findOrFail($id);
        $offDay->offDayTypes()->detach();
        $offDay->delete();
        return response()->json(['message' => 'Off day deleted successfully']);
    }
}