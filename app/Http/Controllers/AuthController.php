<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // TODO change this into UserController and refactor middleware into apis routes
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        // TODO get user_type corresponding to the email and include in token always
        // $user_type = User::where('email', $request->email)->firstOrFail()->user_type;
        // dd($user_type);
        // $token = auth()->claims(['user_type' => $user_type])->attempt($credentials);
        // $payload_user_type = auth()->payload()['user_type'];

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);

        // TODO input all fields
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();


        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    // TODO split this controller into middleware and controller somehow
    public function update(Request $request)
    {
        // TODO authorize before updating
        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();

        return response()->json([
            // TODO return token //TODO make user activate email
            "message" => "Info update successully"
        ], 200);
    }

    public function upgrade(Request $request)
    {
        // TODO authorize before upgrading

        $target_id = $request->target_id;

        $user = User::findOrFail($target_id);
        if ($user) {
            $user->user_type = 1 - $user->user_type; // TODO if this won't work, force fill it
            $user->save();
            return response()->json([
                "message" => "User type changed successfully"
            ], 200);
        }
    }
}
