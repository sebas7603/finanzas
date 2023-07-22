<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'success' => false,
                'msg' => 'No autorizado',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'success' => true,
            'msg' => 'El usuario se ha logueado con éxito',
            'data' => [
                'user' => $user,
                'auth' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ]
            ]
        ]);
    }

    public function register(Request $request) {
        try {
            DB::beginTransaction();
            $user = User::create([
                'names' => $request->names,
                'lastnames' => $request->lastnames,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = Auth::login($user);
            DB::commit();

            return response()->json([
                'success' => true,
                'msg' => 'El usuario se ha creado con éxito',
                'data' => [
                    'user' => $user,
                    'auth' => [
                        'token' => $token,
                        'type' => 'bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60,
                    ]
                ]
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'msg' => 'Ops! Hubo un error inesperado',
                'error' => [
                    'message' => $th->getMessage(),
                    'code' => $th->getCode()
                ]
            ], 404);
        }
    }

    public function logout() {
        Auth::logout();
        return response()->json([
            'success' => true,
            'msg' => 'El usuario se ha salido con éxito',
        ]);
    }

    public function refresh() {
        $token = Auth::refresh();
        return response()->json([
            'success' => true,
            'msg' => null,
            'data' => [
                'auth' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ]
            ]
        ]);
    }
}
