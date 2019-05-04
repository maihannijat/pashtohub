<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
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
        $this->middleware('auth:api', ['except' => ['login']]);
    }


    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     */
    public function login(Request $request)
    {
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

            return response()->json(['error' => 'Unauthorized'], 401);
        }
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

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
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