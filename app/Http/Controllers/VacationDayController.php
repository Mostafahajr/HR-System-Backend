<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreVacationDayRequest;
use App\Http\Requests\UpdateVacationDayRequest;
use App\Http\Resources\VacationDayResource;
use App\Models\VacationDay;
use Illuminate\Http\Request;

class VacationDayController extends Controller
{
    // GET all vacation days
    public function index()
    {
        $vacationDays = VacationDay::all();
        return VacationDayResource::collection($vacationDays);
    }

    // POST create a new vacation day
    public function store(StoreVacationDayRequest $request)
    {
        // Check if there are already 2 days
        if (VacationDay::count() >= 2) {
            return response()->json(['error' => 'You can only have 2 vacation days'], 400);
        }

        $validatedData = $request->validated();
        $vacationDay = VacationDay::create($validatedData);

        return new VacationDayResource($vacationDay);
    }

    // GET single vacation day
    public function show($id)
    {
        $vacationDay = VacationDay::findOrFail($id);
        return new VacationDayResource($vacationDay);
    }
    // PUT a single vacation day
    public function update(UpdateVacationDayRequest $request, $id)
    {
        $vacationDay = VacationDay::findOrFail($id);

        $validatedData = $request->validated();
        $vacationDay->update($validatedData);

        return new VacationDayResource($vacationDay);
    }
    // DELETE a vacation day
    public function destroy($id)
    {
        VacationDay::findOrFail($id)->delete();
        return response()->json(['message' => 'Vacation day deleted successfully']);
    }
}
