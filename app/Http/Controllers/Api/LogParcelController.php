<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogParcelRequest;
use App\Models\LogParcel;
use App\Models\Parcel;
use Illuminate\Http\Request;

class LogParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LogParcelRequest $request)
    {
        try {
            LogParcel::create($request->all());
            Parcel::where('tracking_number', $request->parcel_id)->update([
                'status' => $request->status
            ]);
            return response()->json('updated successfully', 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
