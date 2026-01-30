<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceRoute;
use Illuminate\Http\Request;

class ServiceRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Service $service)
    {
        $excludeIds = $service->routesFrom()->pluck('to_service_id');

        $excludeIds->push($service->id);

        $services = Service::whereNotIn('id', $excludeIds)->get();

        return view('dashboard.route.index', compact('service', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Service $service)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Service $service, Request $request)
    {
        $validated = $request->validate([
            'to_service_id' => ['required', 'exists:services,id', 'different:id'],
        ]);

        $exists = $service->routesFrom()
            ->where('to_service_id', $validated['to_service_id'])
            ->exists();

        if ($exists) {
            return to_route('services.routes.index', $service)
                ->with('error', 'Rute ini sudah terdaftar.');
        }

        $service->routesFrom()->create([
            'to_service_id' => $validated['to_service_id'],
            'step_order' => $service->routesFrom()->count() + 1,
        ]);

        return to_route('services.routes.index', $service)
            ->with('success', 'Rute berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service, ServiceRoute $route)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service, ServiceRoute $route)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service, ServiceRoute $route)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service, ServiceRoute $route)
    {
        $route->delete();
        $service->reorderRoutesFrom();

        return to_route('services.routes.index', $service)->with('success', 'Rute berhasil dihapus.');
    }
}
