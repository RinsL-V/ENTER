<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            // Создаем пользователя
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user'
            ]);

            // Авторизуем пользователя после регистрации
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Регистрация прошла успешно',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при регистрации: ' . $e->getMessage()
            ], 500);
        }
    }

    // Дополнительный метод для проверки доступности имени
    public function checkUsername(Request $request)
    {
        $exists = User::where('name', $request->username)->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Имя пользователя уже занято' : 'Имя доступно'
        ]);
    }

    // Дополнительный метод для проверки доступности email
    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Email уже используется' : 'Email доступен'
        ]);
    }
}
