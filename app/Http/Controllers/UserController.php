<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
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
            $user->status_id = 3;
            $user->password = bcrypt($request->password);
            $user->token = Str::random(64);
            $user->update();

            $email = $user->email;

            // Send email to the user
            Mail::send('account_verification', compact('user'), function ($mail) use ($email) {
                $mail->to($email)
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
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
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
    public function destroy($id)
    {
        return response(User::destroy($id));
    }

    public function verify($first_name, $last_name, $token)
    {
        $user = User::where('first_name', $first_name, 'and')
            ->where('last_name', $last_name, 'and')
            ->where('token', $token)->first();

        if ($user) {
            $user->status_id = 1;
            $user->update();
            return response($user);
        } else {
            return response(['error' => 'Unable to verify the account!']);
        }
    }

    public function forgotPassword(Request $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return response(['error' => 'Email address does not exist in the system!']);
        }

        // Invalidate old tokens
        PasswordReset::whereEmail($user->email)->delete();

        $reset = PasswordReset::create([
            'email' => $user->email,
            'token' => Str::random(64),
        ]);
        $token = $reset->token;
        Mail::send('password_forgot', compact('user', 'token'), function ($mail) use ($user) {
            $mail->to($user->email)
                ->from('no-reply@pashto.io')
                ->subject('Pashto Hub Account Password Reset');
        });
        return response()->json($request, 200);
    }

    public function resetPassword(Request $request)
    {
        $user = User::where('first_name', $request->first_name, 'and')
            ->where('last_name', $request->last_name)->first();


        $user_reset = PasswordReset::whereEmail($user->email)->first();

        if ($user_reset && $user_reset->token === $request->token) {
            $user->password = bcrypt($request->password);

            $user->save();

            // Delete pending resets
            PasswordReset::whereEmail($user->email)->delete();

            return response()->json($request, 200);
        } else {
            return response()->json('Token does not match', 200);
        }
    }
}
