<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VehicleController extends Controller
{
    // LISTAR VEHÍCULOS DEL USUARIO LOGUEADO
    public function index(): View
    {
        $userCedula = Auth::user()->cedula;

        $vehicles = Vehicle::where('user_id', $userCedula)->get();

        return view('vehicles', compact('vehicles'));
    }

    // FORMULARIO DE CREACIÓN
    public function create(): View
    {
        // resources/views/vehicle_create.blade.php
        return view('vehicle_create');
    }

    // GUARDAR VEHÍCULO NUEVO
    public function store(VehicleRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Vincularlo al usuario logueado (users.cedula)
        $data['user_id'] = Auth::user()->cedula;

        // Guardar imagen si viene
        if ($request->hasFile('image')) {
            // Guarda en storage/app/public/vehicles
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        Vehicle::create($data);

        return redirect()
            ->route('vehicles')
            ->with('success', 'Vehículo creado correctamente.');
    }

    // FORMULARIO DE EDICIÓN
    public function edit(Vehicle $vehicle): View
    {
        // Usa la vista: resources/views/Drivers/editVehicles.blade.php
        return view('Drivers.editVehicles', compact('vehicle'));
    }

    // ACTUALIZAR
    public function update(VehicleRequest $request, Vehicle $vehicle): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {

            // Borra imagen anterior si existe
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }

            // Sube nueva y guarda el path
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()
            ->route('vehicles')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    // ELIMINAR
    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }

        $vehicle->delete();

        return redirect()
            ->route('vehicles')
            ->with('success', 'Vehículo eliminado correctamente.');
    }
}
