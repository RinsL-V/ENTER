<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\VerifyRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // Данные уже валидированы в RegisterRequest
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => null,
        ]);

        $this->sendVerificationCode($user, $request->ip());

        return response()->json([
            'message' => 'Код подтверждения отправлен на почту',
        ]);
    }

    public function login(LoginRequest $request)
    {
        // Данные уже валидированы в LoginRequest
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        // Проверки блокировки и лимитов теперь в LoginRequest
        $this->sendVerificationCode($user, $request->ip());

        return response()->json([
            'message' => 'Код подтверждения отправлен на почту',
        ]);
    }

    public function verify(VerifyRequest $request)
    {
        // Данные уже валидированы в VerifyRequest
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();
        $code = VerificationCode::where('user_id', $user->id)
            ->where('code', $validated['code'])
            ->where('used', false)
            ->latest()
            ->first();

        if (!$code || !$code->isValid()) {
            throw ValidationException::withMessages([
                'code' => ['Неверный или просроченный код подтверждения'],
            ]);
        }

        $code->markAsUsed();
        $user->markEmailAsVerified();

        // Удаляем старые токены и создаем новый
        $user->tokens()->delete();
        $token = $user->createToken($request->email)->plainTextToken;

        // Возвращаем пользователя с токеном через Resource
        return response()->json([
            'message' => 'Успешная авторизация',
            'data' => new UserResource($user->setAttribute('token', $token)),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Выход выполнен']);
    }

    public function me(Request $request)
    {
        // Возвращаем пользователя без токена через Resource
        return new UserResource($request->user());
    }

    private function sendVerificationCode(User $user, string $ipAddress)
    {
        $code = rand(100000, 999999);

        VerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
            'ip_address' => $ipAddress,
        ]);

        Mail::raw("Ваш код подтверждения: {$code}", function ($message) use ($user) {
            $message->to($user->email)->subject('Код подтверждения');
        });
    }
}
