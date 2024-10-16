<?php

namespace App\Http\Controllers\Auth;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
        if (!Auth::attempt($request->only('email', 'password')))
            return response()->json(['message' => 'Invalid login credentials'], 401);
        $user = Auth::user();
        $lang = $user->Profile->language;
        App::setLocale($lang);
        return redirect(route('dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
