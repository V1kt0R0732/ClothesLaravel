<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                // Пароль можна не встановлювати, або встановити випадковий
                'password' => Hash::make(str()->random(24))
            ]);

            Auth::login($user, true);

            return redirect()->route('home'); // Перенаправлення після успішної автентифікації

        } catch (\Exception $e) {
            // Обробка помилки
            return redirect('/login')->with('error', 'Щось пішло не так!');
        }
    }
}
