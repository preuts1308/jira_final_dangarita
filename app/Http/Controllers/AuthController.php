<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use \stdClass;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|min:8',
            'role' => 'required|in:gerente,desarrollador'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $user = User::create([
            'name' => $request ->name,
            'email' => $request ->email,
            'password' => Hash::make($request->password),
            'role' => $request ->role
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
        ->json(['data' => $user,'access_token' => $token, 'token_type' =>'Bearer,']);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email','password')))
        {
            return response()
                ->json(['message' =>'No autroizado'],401);
                
        }

        $user = User::where('email',$request['email'])->firstOrFail();
        $token = $user -> createToken('auth_token') ->plainTextToken;

        return response()
            ->json([
                'message' => 'Hola: '.$user->name,
                'accessToken' => $token,
                'token_type' =>'Bearer',
                'user'=>$user,
            ]);
    }
    
    Public function logout()
    {
        auth() -> user() -> tokens() -> delete();
        return[
            'message' => 'Se ha cerrrado sesion correctamente el token ha sido eliminado'
        ];
    }
}
