<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppSettingRequest;
use App\Models\AppSettings;
use Intervention\Image\Laravel\Facades\Image;

class AppSetting extends Controller
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
    public function store(AppSettingRequest $request)
    {
        try {
            if ($request->hasFile('app_logo') && $request->hasFile('app_favicon')) {
                $image = $request->file('app_logo');
                $fav = $request->file('app_logo');

                //Get the Original File Name and path
                $thumbnail = $image->getClientOriginalName();
                $thumbnail1 = $fav->getClientOriginalName();
                //Get the filename only using native php 'pathinfo'
                $filename = pathinfo($thumbnail, PATHINFO_FILENAME);
                $filename1 = pathinfo($thumbnail1, PATHINFO_FILENAME);
                //Extract the Extension
                $ext = strtolower($image->getClientOriginalExtension());
                $ext1 = strtolower($fav->getClientOriginalExtension());
                //prepare the file to be stored
                $nameToStore = $filename . '_'. time() .'.'. $ext;
                $nameToStore1 = $filename1 . '_'. time() .'.'. $ext1;
                //upload the file
                $image_resize = Image::make($image->getRealPath());
                $image_resize1 = Image::make($fav->getRealPath());
                // To resize the image to a width of 600 and constrain aspect ratio (auto height)
                $image_resize->resize(600,  null, function ($constraint) {
                    $constraint->aspectRatio();
                    });
                $image_resize1->resize(600,  null, function ($constraint) {
                    $constraint->aspectRatio();
                    });
                if($image_resize->save(storage_path('app/public/app/'.$nameToStore)) && $image_resize->save(storage_path('app/public/app/'.$nameToStore1))){
                    $app = AppSettings::first();

                    if ($app) {
                        $app->update([
                            'app_name' => $request->app_name,
                            'app_logo' => $nameToStore,
                            'app_favicon' => $nameToStore1,
                            'app_email' => $request->app_email,
                            'app_phone' => $request->app_phone,
                            'app_address' => $request->app_address,
                            'app_description' => $request->app_description,
                        ]);
                    }else{
                        $app = AppSettings::create([
                            'app_name' => $request->app_name,
                            'app_logo' => $nameToStore,
                            'app_favicon' => $nameToStore1,
                            'app_email' => $request->app_email,
                            'app_phone' => $request->app_phone,
                            'app_address' => $request->app_address,
                            'app_description' => $request->app_description,
                        ]);
                    }
                    return response()->json('Saved Successful', 200);
                }else {
                    unlink(storage_path('app/public/app/'.$nameToStore));
                    unlink(storage_path('app/public/app/'.$nameToStore1));
                    return response()->json(['error' => 'something went wrong'], 416);
                }
    
            }else {
                return response()->json(['error' => 'No App Logo or App Favicon'], 416);
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
