<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'tipo_token' => ['nullable', 'in:lectura,escritura'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'mensaje' => 'Credenciales incorrectas'
            ], 401);
        }

        $tipoToken = $request->tipo_token ?? 'lectura';

        $abilities = $tipoToken === 'escritura'
            ? ['ver', 'crear', 'editar', 'eliminar']
            : ['ver'];

        $token = $user->createToken('api-token-' . $tipoToken, $abilities)->plainTextToken;

        return response()->json([
            'usuario' => $user,
            'tipo_token' => $tipoToken,
            'abilities' => $abilities,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'mensaje' => 'Sesión cerrada correctamente'
        ], 200);
    }

    public function perfil(Request $request)
    {
        return response()->json($request->user(), 200);
    }
}