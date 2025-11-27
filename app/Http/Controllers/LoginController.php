<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    /**
     * Authenticate User
     * 
     * Validates user credentials and checks account status before logging in.
     * 
     * @param Request $request The HTTP request containing cedula and password
     * @return RedirectResponse Redirects to index on success or back with errors on failure
     */
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
            return redirect()->route('/index');
        }

        return back()->withErrors([
            'cedula' => 'The provided credentials do not match our records.',
        ])->onlyInput('cedula');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}