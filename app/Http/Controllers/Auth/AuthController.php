<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use \Illuminate\Http\Response;
class AuthController extends Controller
{
    /**
     * Login Index
     */
    public function index()
    {
        return view('login.login');
    }

       /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(LoginRequest $request)
    {
        try {
            if(!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not exists!',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return redirect()->intended(route('admin.index'))->with('status', 'Signed in!');
            //for API use only
            // $user = User::where('email', $request->email)->first();

            // return response()->json([
            //     'status' => true,
            //     'message' => 'User Logged In Successfully',
            //     'token' => $user->createToken("API TOKEN")->plainTextToken
            // ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
