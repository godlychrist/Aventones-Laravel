<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    // ** Authenticate User **
    public function auth(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'cedula'    => 'required|numeric',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->state !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'cedula' => 'Your account is not active.',
                ])->onlyInput('cedula');
            }

            $request->session()->regenerate();
            return redirect()->route('indexM');
        }

        return back()->withErrors([
            'cedula' => 'The provided credentials do not match our records.',
        ])->onlyInput('cedula');
    }
}