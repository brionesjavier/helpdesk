<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Element;
use Illuminate\Http\Request;


class ElementController extends Controller
{
    public function index(){
        $elements = Element::where('is_active',true)->get();
        return view('elements.index',['elements'=>$elements]);
    }

    public function create(){

        $categories = Category::where('is_active',true)->get();
        //return dd($categories);

        return view('elements.create', ['categories'=>$categories]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'required|string|max:300',
            'category_id'=>'required|integer'
        ]);

        //Category::create($request->all());
        Element::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id'=>$request->category_id

        ]);

        return redirect()->route('elements.index')->with('message', 'Categoría creada exitosamente.');

    }
    public function show(Element $element){

        return view('elements.show',['element'=>$element]);
    }
    public function edit(Element $element){
        $categories = Category::where('is_active',true)->get();
        return view('elements.edit',['element'=>$element,'categories'=>$categories]);
        }
    
    public function update(Request $request, Element $element){
            $validate = $request->validate([
                                'name' => 'required|string|max:30',
                                'description' => 'required|string|max:300',
                                'category_id'=>'required|integer'
                                ]);
            $element->update($validate);
            return redirect()->route('elements.index')->with('message', 'Elemento actualizado exitosamente.');
    }
    public function destroy(Element $element){
        $element->delete();
        return redirect()->route('elements.index')->with('message', 'Elemento eliminado exitosamente.');
        }

}
