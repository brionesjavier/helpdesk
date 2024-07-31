<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = State::get();
        return view('states.index', compact('states'));
    }

    public function create()
    {
        return view('states.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:20',]);

        State::create(['name' => $request->name]);

        return redirect()->route('states.index')
            ->with('message', 'estado creado exitosamente.');
    }

    public function show(State $state)
    {
        return view('states.show', compact($state));
    }

    public function edit(State $state)
    {

        return view('states.edit', compact($state));
    }

    public function update(Request $request, State $state)
    {
        $request->validate(['name' => 'required|string|max:20',]);
        $state->update(['name' => $request->name]);

        return redirect()->route('states.index')
            ->with('message', 'estado actualizado exitosamente.');
    }

    public function destroy(State $state)
    {
        $state->delete();
        return redirect()->route('states.index')
            ->with('message', 'Estado eliminado exitosamente.');
    }
}
