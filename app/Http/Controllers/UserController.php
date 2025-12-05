<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Listado de usuarios
     */
    public function index(Request $request): View
    {
        $users = User::paginate(10);

        return view('Admin.EnableDisable', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Formulario de registro
     */
    public function create(): View
    {
        return view('Users.RegistrationPassenger');
    }

    public function createAdmin(): View
    {
        return view('Admin.CreateAdmins');
    }

    /**
     * Guarda un usuario nuevo
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $userType = Auth::check() && Auth::user()->userType === 'admin' ? 'admin' : 'user';

        $state = Auth::check() && Auth::user()->userType === 'admin' ? 'active' : 'pending'; 

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        $user = User::create([
            'cedula'           => $data['cedula'],
            'name'             => $data['name'],
            'lastname'         => $data['lastname'],
            'birthDate'        => $data['birthDate'],
            'email'            => $data['email'],
            'phoneNum'         => $data['phoneNum'],
            'password'         => bcrypt($data['password']),
            'image'            => $imagePath,
            'state'            => $state,
            'userType'         => $userType,
            'token'            => Str::random(60),
            'expiration_token' => now()->addHours(1),
        ]);

        if($userType === 'admin') {
            return redirect()->route('showUsers')
                ->with('success', 'Usuario registrado correctamente.');
        }
        else {
            Mail::to($data['email'])->send(new SendEmail($user));
        }

        return redirect()->route('login')
            ->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * Mostrar perfil de un usuario específico
     */
    public function show($id): View
    {
        $user = User::find($id);
        return view('Users.Profile', compact('user'));
    }

    /**
     * Formulario de edición de usuarios (admin)
     */
    public function edit($cedula): View
    {
        $user = User::where('cedula', $cedula)->firstOrFail();
        return view('Users.edit', compact('user'));
    }

    /**
     * Actualizar usuario (admin)
     */
    public function update($cedula): RedirectResponse
    {
        $user = User::where('cedula', $cedula)->firstOrFail();
        $user->update([
            'state' => $user->state === 'active' ? 'inactive' : 'active',
        ]);

        return Redirect::route('showUsers')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Eliminar usuario
     */
    public function destroy($cedula): RedirectResponse
    {
        User::where('cedula', $cedula)->delete();
        return Redirect::route('Admin.Enable-Disable')
            ->with('success', 'User deleted successfully');
    }

    /**
     * Activar usuario por correo
     */
    public function activate($token)
    {
        $user = User::where('token', $token)->first();
        if ($user) {
            $user->update([
                'state' => 'active',
                'token' => null,
                'expiration_token' => null,
            ]);

            return redirect()->route('login')
                ->with('success', 'Cuenta activada correctamente');
        }

        return redirect()->route('login')
            ->with('error', 'Token inválido');
    }

    /**
     * ============================
     *     PERFIL DE USUARIO
     * ============================
     */

    /**
     * Mostrar perfil del usuario autenticado
     */
    public function profile()
    {
        $user = Auth::user();
        return view('Users.Profile', compact('user'));
    }

    /**
     * Actualizar perfil del usuario autenticado
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validación
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'birthDate' => 'nullable|date',
            'mail'      => 'required|email',
            'phoneNum'  => 'required|string|max:20',
            'image'     => 'nullable|image|max:2048',
        ]);

        // Si sube foto
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('users', 'public');
            $user->image = $data['image'];
        }

        // Actualizar campos
        $user->name      = $data['name'];
        $user->lastname  = $data['lastname'];
        $user->birthDate = $data['birthDate'] ?? $user->birthDate;
        $user->email     = $data['mail'];
        $user->phoneNum  = $data['phoneNum'];

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente');
    }
}
