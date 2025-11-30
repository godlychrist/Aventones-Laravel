<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    /**
     * Display a paginated list of users
     * 
     * @param Request $request The HTTP request
     * @return View The users list view
     */
    public function index(Request $request): View
    {

        $users = User::paginate(10);

        return view('showUsers', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Show the form for creating a new user
     * 
     * @return View The user registration form view
     */
    public function create(): View
    {
        $user = new User();
        return view('Users.registration_passenger');
    }

    /**
     * Store a newly created user in the database
     * 
     * @param UserRequest $request The validated user request
     * @return RedirectResponse Redirects back to registration with success message
     */
    public function store(UserRequest $request): RedirectResponse
    {
    
        $data = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        $user = User::create([
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
        Mail::to($data['email'])->send(new SendEmail($user));

        return redirect()->route('register')
            ->with('success', 'Usuario registrado correctamente.');

    }

    /**
     * Display the specified user
     * 
     * @param int $id The user ID
     * @return View The user detail view
     */
    public function show($id): View
    {
        $user = User::find($id);
        return view('Users.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     * 
     * @param string $cedula The user's cedula (ID number)
     * @return View The user edit form view
     */
    public function edit($cedula): View
    {
        $user = User::where('cedula', $cedula)->firstOrFail();
        return view('Users.edit', compact('user'));

    }

    /**
     * Update the specified user in the database
     * 
     * @param UserRequest $request The validated user request
     * @param string $cedula The user's cedula (ID number)
     * @return RedirectResponse Redirects to users list with success message
     */
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

    /**
     * Remove the specified user from the database
     * 
     * @param string $cedula The user's cedula (ID number)
     * @return RedirectResponse Redirects to users list with success message
     */
    public function destroy($cedula): RedirectResponse
    {
        User::where('cedula', $cedula)->delete();
        return Redirect::route('showUsers')
            ->with('success', 'User deleted successfully');
    }

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
                ->with('success', 'User activated successfully');
        }
        return redirect()->route('login')
            ->with('error', 'Invalid activation token');
    }
}