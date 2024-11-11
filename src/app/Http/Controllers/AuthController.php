<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Registrierung über die Webansicht
    public function webRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrierung erfolgreich. Bitte loggen Sie sich ein.');
    }

    // Login über die Webansicht
    public function webLogin(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->route('dashboard');
    } else {
        // Differenzierte Fehlermeldungen
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return redirect()->route('login')->withErrors('Das eingegebene Passwort ist falsch.');
        } else {
            return redirect()->route('login')->withErrors('Es gibt keinen Benutzer mit dieser E-Mail-Adresse.');
        }
    }
}


    // Logout über die Webansicht
    public function webLogout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Erfolgreich ausgeloggt.');
    }

    // Registrierung über die API
    public function apiRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Registration successful. Please login to get your token.'], 200);
    }

    // Login über die API
    public function apiLogin(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('LaravelSanctumApp')->plainTextToken;
        return response()->json(['token' => $token], 200);
    } else {
        return response()->json(['error' => 'Falsche E-Mail-Adresse oder Passwort.'], 401);
    }
}


    // Logout über die API
    public function apiLogout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
