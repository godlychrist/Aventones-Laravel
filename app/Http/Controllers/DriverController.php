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
    /**
     * Display a paginated list of drivers
     * 
     * @param Request $request The HTTP request
     * @return View The drivers list view
     */
    public function index(Request $request): View
    {
        $drivers = Driver::where('userType', 'driver')->paginate(10);

        return view('Drivers.showDrivers', compact('drivers'))
            ->with('i', ($request->input('page', 1) - 1) * $drivers->perPage());
    }

    /**
     * Show the form for creating a new driver
     * 
     * @return View The driver registration form view
     */
    public function create(): View
    {
        return view('Users.registration_driver');
    }

    /**
     * Store a newly created driver in the database
     * 
     * @param DriverRequest $request The validated driver request
     * @return RedirectResponse Redirects back to registration with success message
     */
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

    /**
     * Display the specified driver
     * 
     * @param int $id The driver ID
     * @return View The driver detail view
     */
    public function show($id): View
    {
        $driver = Driver::find($id);
        return view('showDriver', compact('driver'));
    }

    /**
     * Show the form for editing the specified driver
     * 
     * @param string $cedula The driver's cedula (ID number)
     * @return View The driver edit form view
     */
    public function edit($cedula): View
    {
        $driver = Driver::where('cedula', $cedula)->firstOrFail();
        return view('editDriver', compact('driver'));
    }

    /**
     * Update the specified driver in the database
     * 
     * @param DriverRequest $request The validated driver request
     * @param string $cedula The driver's cedula (ID number)
     * @return RedirectResponse Redirects to drivers list with success message
     */
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

    /**
     * Remove the specified driver from the database
     * 
     * @param string $cedula The driver's cedula (ID number)
     * @return RedirectResponse Redirects to drivers list with success message
     */
    public function destroy($cedula): RedirectResponse
    {
        Driver::where('cedula', $cedula)->delete();
        return redirect()->route('showDrivers')
            ->with('success', 'Conductor eliminado correctamente.');
    }
}
