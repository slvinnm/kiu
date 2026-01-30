<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counters = Counter::latest()->get();

        return view('dashboard.counter.index', compact('counters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.counter.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
            ]
        );

        $counter = Counter::create([
            'name' => $validated['name'],
            'status' => Counter::STATUS_OPEN,
        ]);

        $counter->operator()->create([
            'role_id' => Role::COUNTER,
            'name' => $validated['username'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        return to_route('counters.index')->with('success', 'Loket pemanggil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Counter $counter)
    {
        $counter->load('operator');

        return view('dashboard.counter.show', compact('counter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Counter $counter)
    {
        $counter->load('operator');

        return view('dashboard.counter.edit', compact('counter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Counter $counter)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $counter->operator->id],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $counter->operator->id],
                'password' => ['nullable', 'string', 'min:8'],
            ]
        );

        $counter->update([
            'name' => $validated['name'],
        ]);

        $counter->operator->update([
            'name' => $validated['username'],
            'email' => $validated['email'],
            'username' => $validated['username'],
        ]);

        if (! empty($validated['password'])) {
            $counter->operator->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return to_route('counters.index')->with('success', 'Loket pemanggil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Counter $counter)
    {
        $counter->operator->delete();
        $counter->delete();

        return to_route('counters.index')->with('success', 'Loket pemanggil berhasil dihapus.');
    }
}
