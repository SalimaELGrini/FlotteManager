<?php

namespace App\Http\Controllers\Drivers;

use App\Http\Controllers\Controller;

use App\Http\Requests\Drivers\StoreDriverRequest;
use App\Http\Requests\Drivers\UpdateDriverRequest;
use App\Services\Drivers\DriverService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;
use Spatie\Browsershot\Browsershot;
use Illuminate\Http\Request;

class ControllerDriver extends Controller
{
    protected $driverService;

    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    public function index(Request $request)
    {
        $drivers = $this->driverService->getAllDrivers($request->input('search'));
        return view('pages.drivers.index', compact('drivers'));
    }

    public function create()
    {
        Gate::authorize('createDriver');
        return view('pages.drivers.create');
    }

    public function store(StoreDriverRequest $request)
    {
        Gate::authorize('createDriver');
        $this->driverService->createDriver($request->validated());
        return redirect()->route('drivers.index')->with('success', 'Conducteur ajouté avec succès.');
    }

    public function show($id)
    {
        Gate::authorize('viewDriver');
        $driver = $this->driverService->findDriverById($id);
        return view('pages.drivers.show', compact('driver'));
    }

    public function edit($id)
    {
        Gate::authorize('editDriver');
        $driver = $this->driverService->findDriverById($id);
        return view('pages.drivers.edit', compact('driver'));
    }

    public function update(UpdateDriverRequest $request, $id)
    {
        Gate::authorize('editDriver');
        $this->driverService->updateDriver($id, $request->validated());
        return redirect()->route('drivers.index')->with('success', 'Conducteur mis à jour avec succès.');
    }

    public function destroy($id)
    {
        Gate::authorize('deleteDriver');
        $this->driverService->deleteDriver($id);
        return redirect()->route('drivers.index')->with('success', 'Conducteur supprimé avec succès.');
    }

    public function exportPDF($id)
    {
        $driver = $this->driverService->findDriverById($id);
        $locale = app()->getLocale();
        App::setLocale($locale);
        $html = View::make('pages.drivers.pdf', compact('driver', 'locale'))->render();
        $pdfPath = storage_path("app/public/driver_{$driver->id}.pdf");

        ini_set('max_execution_time', 120);

        Browsershot::html($html)
            ->setChromePath('C:\Program Files (x86)\Microsoft\Edge\Application\msedge.exe')
            ->format('A4')
            ->margins(5, 5, 5, 5)
            ->timeout(90)
            ->save($pdfPath);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}
