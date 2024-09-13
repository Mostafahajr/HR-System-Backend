<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOffDayTypeRequest;
use App\Http\Requests\UpdateOffDayTypeRequest;
use App\Http\Resources\OffDayTypeResource;
use App\Models\OffDayType;
use Illuminate\Http\Request;

class OffDayTypeController extends Controller
{
    // GET all off day types
    public function index()
    {
        $offDayTypes = OffDayType::all();
        return OffDayTypeResource::collection($offDayTypes);
    }

    // POST create a new off day type
    public function store(StoreOffDayTypeRequest $request)
    {
        $validatedData = $request->validated();
        $offDayType = OffDayType::create($validatedData);

        return new OffDayTypeResource($offDayType);
    }

    // GET single off day type
    public function show($id)
    {
        $offDayType = OffDayType::findOrFail($id);
        return new OffDayTypeResource($offDayType);
    }

    // PUT update an existing off day type
    public function update(UpdateOffDayTypeRequest $request, $id)
    {
        $offDayType = OffDayType::findOrFail($id);

        $validatedData = $request->validated();
        $offDayType->update($validatedData);

        return new OffDayTypeResource($offDayType);
    }

    // DELETE an off day type
    public function destroy($id)
    {
        OffDayType::findOrFail($id)->delete();
        return response()->json(['message' => 'Off day type deleted successfully']);
    }
}
