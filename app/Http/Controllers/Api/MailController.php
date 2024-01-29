<?php

namespace App\Http\Controllers\Api;

use App\Models\MailModel;
use Illuminate\Http\Request;
use App\Http\Requests\MailRequest;
use App\Http\Controllers\Controller;
use App\Notifications\SendMailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $get = MailModel::latest()->paginate(20);
            return response()->json($get, 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MailRequest $request)
    {
        try {
            MailModel::create($request->all());
            Notification::route('mail', $request->email)
            ->notify(new SendMailNotification($request->subject, $request->message));
            return response()->json('Email sent successful', 200);
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
        try {
            $mail = MailModel::findOrFail($id);
            $mail->delete();
            return response()->json('Deleted successful', 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
