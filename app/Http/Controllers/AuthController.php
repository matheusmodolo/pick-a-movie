<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Lógica de autenticação
    public function login(Request $request)
    {
        // Autenticação (email e senha)
        $token = auth('api')->attempt($request->only('email', 'password'));

        // Retornar um JWT (Json Web Token)
        if ($token) {
            return response()->json(['token' => $token]);
        }
        return response()->json(['error' => 'Usuário e/ou senha inválidos!'], 403);
    }

    // Lógica de logout
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }

    // Lógica de refresh do token
    public function refresh()
    {
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }

    // Retorna informações do usuário autenticado
    public function me()
    {
        return response()->json(auth()->user());
    }
}
