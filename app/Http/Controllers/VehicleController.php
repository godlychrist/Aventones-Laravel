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
    /**
     * Display a list of vehicles for the authenticated user
     * 
     * @return View The vehicles list view
     */
    public function index(): View
    {
        $userCedula = Auth::user()->cedula;

        $vehicles = Vehicle::where('user_id', $userCedula)->get();

        return view('Drivers.showVehicles', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle
     * 
     * @return View The vehicle creation form view
     */
    public function create(): View
    {
        return view('Drivers.registerVehicles');
    }

    /**
     * Store a newly created vehicle in the database
     * 
     * Links the vehicle to the authenticated user and handles image upload.
     * 
     * @param VehicleRequest $request The validated vehicle request
     * @return RedirectResponse Redirects to vehicles list with success message
     */
    public function store(VehicleRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['user_id'] = Auth::user()->cedula;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        Vehicle::create($data);

        return redirect()
            ->route('vehicles')
            ->with('success', 'Vehículo creado correctamente.');
    }

    /**
     * Show the form for editing the specified vehicle
     * 
     * @param Vehicle $vehicle The vehicle model instance
     * @return View The vehicle edit form view
     */
    public function edit(Vehicle $vehicle): View
    {
        return view('Drivers.editVehicles', compact('vehicle'));
    }

    /**
     * Update the specified vehicle in the database
     * 
     * Handles image replacement if a new image is uploaded.
     * 
     * @param VehicleRequest $request The validated vehicle request
     * @param Vehicle $vehicle The vehicle model instance
     * @return RedirectResponse Redirects to vehicles list with success message
     */
    public function update(VehicleRequest $request, Vehicle $vehicle): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {

            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }

            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()
            ->route('vehicles')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    /**
     * Remove the specified vehicle from the database
     * 
     * Deletes the vehicle's image from storage before removing the record.
     * 
     * @param Vehicle $vehicle The vehicle model instance
     * @return RedirectResponse Redirects to vehicles list with success message
     */
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
