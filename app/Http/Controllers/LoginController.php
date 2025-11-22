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
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->state !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is not active.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->route('indexM');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}