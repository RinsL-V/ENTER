<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials, $request->remember)) {
                $user = Auth::user();

                return response()->json([
                    'success' => true,
                    'message' => 'Авторизация прошла успешно',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Неверный email или пароль'
            ], 401);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при авторизации: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => true,
                'message' => 'Выход выполнен успешно'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при выходе: ' . $e->getMessage()
            ], 500);
        }
    }

    public function user(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user) {
                return response()->json([
                    'success' => true,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Пользователь не авторизован'
            ], 401);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении данных пользователя: ' . $e->getMessage()
            ], 500);
        }
    }

    // Дополнительный метод для проверки авторизации
    public function checkAuth(Request $request)
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::check() ? [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'role' => Auth::user()->role
            ] : null
        ]);
    }
}
