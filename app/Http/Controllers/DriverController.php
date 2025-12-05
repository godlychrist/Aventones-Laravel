<?php
namespace App\Http\Controllers;

use App\Http\Requests\DriverRequest;
use App\Models\Driver;
use App\Models\User; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class DriverController extends Controller
{
    // ...existing code...

    public function index(Request $request): View
    {
        $drivers = Driver::where('userType', 'driver')->paginate(10);

        return view('Drivers.ShowDrivers', compact('drivers'))
            ->with('i', ($request->input('page', 1) - 1) * $drivers->perPage());
    }

    public function create(): View
    {
        return view('Users.RegistrationDriver');
    }

    public function store(DriverRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('drivers', 'public');
        }

        $driver  = Driver::create([
            'cedula'           => $data['cedula'],
            'name'             => $data['name'],
            'lastname'         => $data['lastname'],
            'birthDate'        => $data['birthDate'],
            'email'            => $data['email'],
            'phoneNum'         => $data['phoneNum'],
            'password'         => bcrypt($data['password']),
            'image'            => $imagePath,
            'state'            => 'pending',
            'userType'         => 'driver',
            'token'            => Str::random(60),
            'expiration_token' => now()->addHours(1),
        ]);

        Mail::to($data['email'])->send(new SendEmail($driver));

        return redirect()->route('registerDriver')
            ->with('success', 'Conductor registrado correctamente.');
    }

    public function show($id): View
    {
        $driver = Driver::find($id);
        return view('showDriver', compact('driver'));
    }

    public function edit($cedula): View
    {
        $driver = Driver::where('cedula', $cedula)->firstOrFail();
        return view('editDriver', compact('driver'));
    }

    public function update(DriverRequest $request, $cedula): RedirectResponse
    {
        $driver = Driver::where('cedula', $cedula)->firstOrFail();
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('drivers', 'public');
        }

        $driver->update($data);

        return redirect()->route('showDrivers')
            ->with('success', 'Conductor actualizado correctamente.');
    }

    public function destroy($cedula): RedirectResponse
    {
        Driver::where('cedula', $cedula)->delete();
        return redirect()->route('showDrivers')
            ->with('success', 'Conductor eliminado correctamente.');
    }

    public function activate($token)
    {
   
        $user = User::where('token', $token)->first();

        if (!$user) {
            return redirect()->route('login') 
                ->with('error', 'El enlace de activación no es válido o ya fue utilizado.');
        }

        $user->update([
            'state'            => 'active',
            'token'            => null,
            'expiration_token' => null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Cuenta activada correctamente.');
    }

    // ...existing code...
}