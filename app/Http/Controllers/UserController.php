<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{

    public function index(Request $request): View
    {

        $users = User::paginate(10);

        return view('showUsers', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * $users->perPage());
    }

    public function create(): View
    {
        $user = new User();
        return view('registration_passenger');
    }

    public function store(UserRequest $request): RedirectResponse
    {
    
        $data = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        User::create([
            'cedula'           => $data['cedula'] ?? null,
            'name'             => $data['name'] ?? null,
            'lastname'         => $data['lastname'] ?? null,
            'birthDate'        => $data['birthDate'] ?? null,
            'email'            => $data['email'] ?? null,
            'phoneNum'         => $data['phoneNum'] ?? null,
            'password'         => bcrypt($data['password'] ?? null),
            'image'            => $imagePath ?? null,
            'state'            => 'pending',
            'userType'         => 'user',
            'token'            => Str::random(60),
            'expiration_token' => now()->addHours(1),
        ]);

        return redirect()->route('registration_passenger')
            ->with('success', 'Usuario registrado correctamente.');

    }

    public function show($id): View
    {
        $user = User::find($id);
        return view('showUser', compact('user'));
    }

    public function edit($cedula): View
    {
        $user = User::where('cedula', $cedula)->firstOrFail();
        return view('edit', compact('user'));

    }

    public function update(UserRequest $request, $cedula): RedirectResponse
    {

        $user = User::where('cedula', $cedula)->firstOrFail();
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        $user->update($data);

        return Redirect::route('showUsers')
            ->with('success', 'User updated successfully');

    }

    public function destroy($cedula): RedirectResponse
    {
        User::where('cedula', $cedula)->delete();
        return Redirect::route('showUsers')
            ->with('success', 'User deleted successfully');
    }
}