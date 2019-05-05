<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    use ThrottlesLogins;
    protected $JWTAuth;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $JWTAuth)
    {
        $this->JWTAuth = $JWTAuth;
        $this->middleware('auth:api', ['except' => ['login', 'verify']]);
    }


    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:64',
            'password' => 'required|min:6|max:64',
        ]);

        try {
            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                $seconds = $this->limiter()->availableIn(
                    $this->throttleKey($request)
                );

                return response()->json(['seconds' => $seconds], 401);
            }

            $credentials = request(['email', 'password']);

            if ($token = $this->JWTAuth->attempt($credentials)) {
                return $this->respondWithToken($token);
            } else {
                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                $this->incrementLoginAttempts($request);

                return response()->json(['error' => 'Unauthorized Access'], 401);
            }
        } catch (Exception $exception) {
            // TODO send email to admin for the error
            return response(['error' => 'Something went wrong - Could not login the user'], 500);
        }
    }

    /**
     * Verifies the user with token, id and first name
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verify(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|max:64',
            'first_name' => 'required|max:64',
            'id' => 'required|digits:10|integer',
        ]);

        try {
            $user = User::where('id', $request->id, 'and')
                ->where('first_name', $request->first_name, 'and')
                ->where('token', $request->token)->first();

            if ($user) {
                $user->status_id = 1;
                $user->update();
                return response(['message' => 'The user has been verified']);
            } else {
                return response(['error' => 'Unable to verify the user!']);
            }
        } catch (Exception $exception) {
            // TODO send email to admin for the error
            return response(['error' => 'Something went wrong - Could not verify the user'], 500);
        }
    }

    /**
     * Accept a request for the forgot password and sends out the instructions in email
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function forgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:64'
        ]);

        try {
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
                    ->subject('Pashto Hub User Password Reset');
            });
            return response(['message' => 'The email has been sent for resetting the password']);
        } catch (Exception $exception) {
            // TODO send email to admin for the error
            return response(['error' => 'Something went wrong - Could not process the request for forgot password'], 500);
        }
    }

    /**
     * Change the password
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|digits:10|integer',
            'first_name' => 'required|max:64',
            'password' => 'required|min:6|max:64'
        ]);

        try {
            $user = User::where('id', $request->id, 'and')
                ->where('first_name', $request->first_name)->first();


            $user_reset = PasswordReset::whereEmail($user->email)->first();

            if ($user_reset && $user_reset->token === $request->token) {
                $user->password = bcrypt($request->password);

                $user->update();

                // Delete pending resets
                PasswordReset::whereEmail($user->email)->delete();

                return response(['message' => 'The password has been successfully changed']);
            } else {
                return response(['error' => 'Token does not match']);
            }
        } catch (Exception $exception) {
            // TODO send email to admin for the error
            return response(['error' => 'Something went wrong - Could not reset the password'], 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the login username to be used by the controller (ThrottlesLogins).
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
}