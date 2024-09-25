<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $user = Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');
    
        // Return user data and token separately
        return response()->json([
            'user' => $user,  // Return the User object directly
            'access_token' => $tokenResult->accessToken,  // Token string
            'token_type' => 'Bearer',  // Token type
            'roles' => $user->roles->pluck('name'),  // User roles
            'permissions' => $user->getAllPermissions(),  // User permissions
        ]);
    }
        
}
