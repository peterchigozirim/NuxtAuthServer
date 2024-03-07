<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class CreateUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            if (!Gate::allows('is_admin', Auth::user())) {
                return response()->json([
                    'message' => 'Unauthorized Access'
                ],401);
            }else{
                $user = User::where('roles', 'user')->paginate(20);
                return response()->json($user, 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if (!Gate::allows('is_admin', Auth::user())) {
                return response()->json([
                    'message' => 'Unauthorized Access'
                ],401);
            }else{
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                    'password' => ['required', Rules\Password::defaults()],
                ]);
        
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'show_password' => $request->password,
                ]);
                return response()->json(['message' => 'User Created Successfully'], 201);
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
        try {
            if (!Gate::allows('is_admin', Auth::user())) {
                return response()->json([
                    'message' => 'Unauthorized Access'
                ],401);
            }else{
                $user = User::find($id);
                $user->update([
                    'password' => Hash::make($request->password),
                    'show_password' => $request->password,
                ]);
                return response()->json(['message' => 'User Password Changed Successfully'], 200);
            }
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
            if (!Gate::allows('is_admin', Auth::user())) {
                return response()->json([
                    'message' => 'Unauthorized Access'
                ],401);
            }else{
                User::find($id)->delete();
                return response()->json(['message' => 'User Deleted Successfully'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
