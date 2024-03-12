<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParcelRequest;
use App\Models\AppSettings;
use App\Models\LogParcel;
use App\Models\Parcel;
use Illuminate\Http\Request;

class ParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(Parcel::latest()->paginate(20), 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function getTrackNumber(Request $request)
    {
        try {
            $request->validate([
                'tracking_number' => 'required'
            ]);
            $get = Parcel::where('tracking_number', $request->tracking_number)->first();
            if ($get) {
                return response()->json($get, 200);
            } else {
                return response()->json('Tracking Number Not Found', 400);
            }
            
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParcelRequest $request)
    {
        try {
            $app = AppSettings::first();
            $track_number = $app? $app->app_name.'-'.time() : 'SWB-'.time();
            $parcel = Parcel::create([
                    'tracking_number' => $track_number,
                    'sender_name' => $request->sender_name,
                    'recepient' => $request->recepient,
                    'recepient_email' => $request->recepient_email,
                    'recepient_phone' => $request->recepient_phone,
                    'recepient_address' => $request->recepient_address,
                    'recepient_country' => $request->recepient_country,
                    'parcel_description' => $request->parcel_description,
                    'logitsic_type' => $request->logitsic_type,
                    'weight' => $request->weight,
                    'location' => $request->location,
                    'total_days' => $request->total_days,
                    'deputuer_day' => $request->deputuer_day,
                    'arrival_day' => $request->arrival_day,
                ]);
            if ($parcel) {
                LogParcel::create([
                    'parcel_id' => $parcel->tracking_number,
                    'location' => $parcel->location,
                    'activity' => 'Parcel have been created!',
                ]);
                return response()->json('success', 201);
            }else{
                return response()->json('something went error', 400);
            }
            
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $parcel = Parcel::where('tracking_number', $id)->first();
            $logs  = LogParcel::where('parcel_id', $parcel->tracking_number)->get();
            return response()->json([
                'parcel' => $parcel,
                'logs' => $logs,
            ],200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParcelRequest $request, string $id)
    {
        try {
            Parcel::where('id', $id)->update($request->all());
            return response()->json('Added successfully', 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $parcel = Parcel::findOrFail($id);
            $parcel->delete();
            LogParcel::where('parcel_id', $parcel->tracking_number)->delete();
            return response()->json('success', 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
