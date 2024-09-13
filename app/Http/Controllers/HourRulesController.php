<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHourRuleRequest;
use App\Http\Requests\UpdateHourRuleRequest;
use App\Http\Resources\HourRuleResource;
use App\Models\HourRule;
use Illuminate\Http\Request;

class HourRulesController extends Controller
{
    // GET all hour rules
    public function index()
    {
        $hourRules = HourRule::all();
        return HourRuleResource::collection($hourRules);
    }

    // POST create a new hour rule
    public function store(StoreHourRuleRequest $request)
    {
        $validatedData = $request->validated();
        $hourRule = HourRule::create($validatedData);

        return new HourRuleResource($hourRule);
    }

    // GET single hour rule
    public function show($id)
    {
        $hourRule = HourRule::findOrFail($id);
        return new HourRuleResource($hourRule);
    }

    // PUT update an existing hour rule
    public function update(UpdateHourRuleRequest $request, $id)
    {
        $hourRule = HourRule::findOrFail($id);

        $validatedData = $request->validated();
        $hourRule->update($validatedData);

        return new HourRuleResource($hourRule);
    }

    // DELETE an hour rule
    public function destroy($id)
    {
        HourRule::findOrFail($id)->delete();

        return response()->json(['message' => 'Hour Rule deleted successfully']);
    }
}
