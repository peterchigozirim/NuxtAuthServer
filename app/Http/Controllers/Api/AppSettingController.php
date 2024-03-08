<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppSettingRequest;
use App\Models\AppSettings;
use Intervention\Image\Laravel\Facades\Image;

class AppSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $app = AppSettings::first();
            return response()->json($app, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppSettingRequest $request)
    {
        try {
            $app = AppSettings::first();

            if ($app) {
                $app->update([
                    'app_name' => $request->app_name,
                    'app_short_name' => $request->app_short_name,
                    'app_email' => $request->app_email,
                    'app_phone' => $request->app_phone,
                    'app_address' => $request->app_address,
                    'app_description' => $request->app_description,
                ]);
            }else{
                $app = AppSettings::create([
                    'app_name' => $request->app_name,
                    'app_short_name' => $request->app_short_name,
                    'app_email' => $request->app_email,
                    'app_phone' => $request->app_phone,
                    'app_address' => $request->app_address,
                    'app_description' => $request->app_description,
                ]);
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
