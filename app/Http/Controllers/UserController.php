<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $user = User::create($request->all());
            $user->password = bcrypt($request->password);
            $user->token = Str::random(64);
            $user->update();

            // Send email to the user
            Mail::send('account_verification', compact('user'), function ($mail) use ($user) {
                $mail->to($user->email)
                    ->from('no-reply@pashto.io')
                    ->subject('Verify Your Pashto Hub Account');
            });

            return response($user);
        } catch (QueryException $exception) {
            return response($exception);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::find($id);
        if ($user) {
            return response($user);
        } else {
            return response(['error' => 'User not found']);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->update($request->all());
            if ($request->password) $user->password = bcrypt($request->password);
            $user->update();
            return response($user);
        } catch (QueryException $exception) {
            return response($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
    }

    public function deactivate()
    {
        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->status_id = 3;
            $user->update();
            return response($user);
        } catch (QueryException $exception) {
            return response($exception);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
}
