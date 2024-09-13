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

    // POST create or update an off day
    public function store(StoreOffDayRequest $request)
    {
        $validatedData = $request->validated();

        // Check if the 'holiday' type exists
        $holidayType = OffDayType::firstOrCreate(
            ['name' => 'holiday'],
            ['description' => 'Default holiday type']
        );

        // Check if the off day already exists
        $offDay = OffDay::where('date', $validatedData['date'])->first();

        if ($offDay) {
            // The off day already exists, check if it has the 'holiday' type associated
            if ($offDay->offDayTypes->contains($holidayType->id)) {
                // If the holiday type is already associated, block the user
                return response()->json(['error' => 'This off day already has a holiday type associated'], 400);
            }

            // Attach the holiday type if it's not associated
            $offDay->offDayTypes()->attach($holidayType->id);

            // Update the description if provided in the request
            if (isset($validatedData['description'])) {
                $offDay->description = $validatedData['description'];
                $offDay->save();
            }

            return new OffDayResource($offDay);
        } else {
            // Create a new off day and associate it with the holiday type
            $offDay = OffDay::create($validatedData);
            $offDay->offDayTypes()->attach($holidayType->id);

            return new OffDayResource($offDay);
        }
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
        // Find the off day and validate the input data
        $offDay = OffDay::findOrFail($id);
        $validatedData = $request->validated();

        // Find the 'holiday' type
        $holidayType = OffDayType::where('name', 'holiday')->firstOrFail();

        // Check if the 'holiday' type is already associated in the pivot table
        $alreadyHasHolidayType = $offDay->offDayTypes()->where('off_day_type_id', $holidayType->id)->exists();

        if (!$alreadyHasHolidayType) {
            // If it's not in the pivot table, attach it
            $offDay->offDayTypes()->attach($holidayType->id);
        }

        // Update the off day's description
        $offDay->update(['description' => $validatedData['description']]);

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
