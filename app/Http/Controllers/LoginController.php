<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Models\User;
use App\Models\LoginToken;
use App\Mail\MagicLinkMail;

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
            return redirect()->route('index');
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

    /**
     * Show the magic link request form
     */
    public function showMagicLinkForm(): View
    {
        return view('Users.magic-link-request');
    }

    /**
     * Send magic link to user's email
     */
    public function sendMagicLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Don't reveal if email exists or not (security best practice)
            return back()->with('success', 'Si el correo existe en nuestro sistema, recibirás un enlace de acceso.');
        }

        // Check if user is active
        if ($user->state !== 'active') {
            return back()->withErrors([
                'email' => 'Tu cuenta no está activa.',
            ]);
        }

        // Generate token
        $loginToken = LoginToken::generateToken($request->email);

        // Create magic link URL
        $loginUrl = route('magic-link.login', ['token' => $loginToken->token]);

        // Send email
        try {
            Mail::to($request->email)->send(new MagicLinkMail($loginUrl, $request->email));
            
            return back()->with('success', 'Si el correo existe en nuestro sistema, recibirás un enlace de acceso. Revisa tu bandeja de entrada.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Hubo un error al enviar el correo. Por favor intenta de nuevo.',
            ]);
        }
    }

    /**
     * Login user with magic link token
     */
    public function loginWithToken(Request $request, string $token): RedirectResponse
    {
        // Find token
        $loginToken = LoginToken::where('token', $token)->first();

        // Validate token
        if (!$loginToken || !$loginToken->isValid()) {
            return redirect()->route('login')->withErrors([
                'token' => 'El enlace de acceso es inválido o ha expirado. Por favor solicita uno nuevo.',
            ]);
        }

        // Find user by email
        $user = User::where('email', $loginToken->email)->first();

        if (!$user || $user->state !== 'active') {
            $loginToken->markAsUsed();
            return redirect()->route('login')->withErrors([
                'token' => 'No se pudo completar el inicio de sesión.',
            ]);
        }

        // Mark token as used
        $loginToken->markAsUsed();

        // Login user
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('index')->with('success', '¡Bienvenido! Has iniciado sesión correctamente.');
    }
}