<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $this->sendVerificationCode($user);

        return response()->json([
            'message' => 'Код подтверждения отправлен на почту',
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $this->sendVerificationCode($user);

        return response()->json([
            'message' => 'Код подтверждения отправлен на почту',
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'code' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user->verification_code || $user->verification_code !== $request->code) {
            throw ValidationException::withMessages([
                'code' => ['Неверный код подтверждения'],
            ]);
        }

        if (now()->greaterThan($user->verification_expires_at)) {
            throw ValidationException::withMessages([
                'code' => ['Код подтверждения истёк'],
            ]);
        }

        $user->verification_code = null;
        $user->verification_expires_at = null;
        $user->email_verified_at = $user->email_verified_at ?? now();
        $user->save();

        Auth::login($user);

        return response()->json([
            'message' => 'Успешная авторизация',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Выход выполнен']);
    }

    public function me(Request $request)
    {
        return response()->json(Auth::user());
    }

    private function sendVerificationCode(User $user)
    {
        $code = rand(100000, 999999);
        $user->verification_code = $code;
        $user->verification_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::raw("Ваш код подтверждения: {$code}", function ($message) use ($user) {
            $message->to($user->email)->subject('Код подтверждения');
        });
    }
}
