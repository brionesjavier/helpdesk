<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states =State::get();
        return view('states.index', compact('states'));
    }
    public function create(){
        return view('states.create');
    }
    public function store(Request $request){
        $state = new State();
        $state->name = $request->name;
        $state->save();
        return redirect()->route('states.index');
    }
    public function show($id){
        $state = State::find($id);
        return view('states.show', compact('state'));
    }
    public function edit($id){
        $state = State::find($id);
        return view('states.edit', compact('state'));
    }
    public function update(Request $request, $id){
        $state = State::find($id);
        $state->name = $request->name;
        $state->save();
        return redirect()->route('states.index');
        }
    public function destroy($id){
        $state = State::find($id);
        $state->delete();
        return redirect()->route('states.index');
    }  
    


}
