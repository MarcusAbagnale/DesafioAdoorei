<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessTokenController extends Controller
{
    public function generateToken(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $token = $this->createToken($user, 'Nome do Token');

        return response()->json(['token' => $token]);
    }


    private function createToken($user, $name)
    {
        return $user->createToken($name)->plainTextToken;
    }
}
