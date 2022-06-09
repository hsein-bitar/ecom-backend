<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{

    public function login(Request $request)
    {
        // validate user input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);


        // get user_type corresponding to the email and include in token always
        $credentials = $request->only('email', 'password');
        // $user_type = User::where('email', $credentials['email'])->firstOrFail()->user_type;
        // $token = Auth::claims(['user_type' => $user_type])->attempt($credentials);
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
            'message' => 'Successfully logged in',
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

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->gender = $request->gender;
        $user->user_type = 0;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();
        $user->id = $user->id;

        // $token = Auth::claims(['user_type' => $user->user_type])->login($user);
        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully registered and logged in',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'message' => 'Your token was refreshed',
            'authorisation' => [
                'token' => Auth::refresh(),
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


    public function update(Request $request)
    {
        $user = auth()->user();
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully updated your info'
        ], 200);
    }

    public function index(Request $request)
    {
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'users' => $users,
        ], 200);
    }

    public function upgrade(Request $request)
    {
        $target = User::findOrFail($request->target_id);
        if ($target) {
            $target->user_type = 1 - $target->user_type;
            $target->save();
            return response()->json([
                'status' => 'success',
                "message" => "User type toggled successfully"
            ], 200);
        }
    }
}
