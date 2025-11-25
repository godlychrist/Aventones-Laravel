<?php
namespace App\Http\Controllers;

use App\Http\Requests\DriverRequest;
use App\Models\Driver;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DriverController extends Controller
{
    // ===== LISTADO =====
    public function index(Request $request): View
    {
        $drivers = Driver::where('userType', 'driver')->paginate(10);

        return view('showDrivers', compact('drivers'))
            ->with('i', ($request->input('page', 1) - 1) * $drivers->perPage());
    }

    // ===== FORMULARIO DE CREACIÓN =====
    public function create(): View
    {
        return view('registration_driver');
    }

    // ===== GUARDAR =====
    public function store(DriverRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('drivers', 'public');
        }

        Driver::create([
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

        return redirect()->route('registerDriver')
            ->with('success', 'Conductor registrado correctamente.');
    }

    // ===== MOSTRAR UNO =====
    public function show($id): View
    {
        $driver = Driver::find($id);
        return view('showDriver', compact('driver'));
    }

    // ===== EDITAR =====
    public function edit($cedula): View
    {
        $driver = Driver::where('cedula', $cedula)->firstOrFail();
        return view('editDriver', compact('driver'));
    }

    // ===== ACTUALIZAR =====
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
}
