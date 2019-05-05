<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Utils\SendEmail;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends BaseController
{

    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:64',
            'last_name' => 'required|max:64',
            'email' => 'required|unique:users|email|max:64',
            'password' => 'required|min:6|max:64',
            'country_id' => 'integer|digits:10',
            'phone' => 'max:64',
        ]);

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

            return response(['message' => 'The user has been successfully created']);
        } catch (Exception $exception) {
            // Send email to the administrator
            SendEmail::sendError($exception);
            return response(['error' => 'Something went wrong - Could not create the user'], 500);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'max:64',
            'last_name' => 'max:64',
            'password' => 'min:6|max:64',
            'country_id' => 'integer|digits:10',
            'phone' => 'max:64',
        ]);

        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->update($request->all());
            if ($request->password) $user->password = bcrypt($request->password);
            $user->update();
            return response(['message' => 'The user has been successfully updated', 'data' => $user]);
        } catch (Exception $exception) {
            // Send email to the administrator
            SendEmail::sendError($exception);
            return response(['error' => 'Something went wrong - Could not update the user'], 500);
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
    }

    /**
     * Deactivate the current authenticated User
     * @return \Illuminate\Http\Response
     */
    public function deactivate()
    {
        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->status_id = 3;
            $user->update();
            return response(['message' => 'The user has been successfully deactivated']);
        } catch (Exception $exception) {
            // Send email to the administrator
            SendEmail::sendError($exception);
            return response(['error' => 'Something went wrong - Could not deactivate the user'], 500);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response(auth()->user());
    }
}
