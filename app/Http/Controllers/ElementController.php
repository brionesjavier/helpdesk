<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Element;
use Illuminate\Http\Request;


class ElementController extends Controller
{


    public function index(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'search' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);

        // Extraer los valores validados o establecer valores predeterminados
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $elements = Element::query()
            ->where('is_active', 1) // Filtrar solo elementos activos
            ->when($search, function ($query, $search) {
                $search = strtolower($search); // Convertir el término de búsqueda a minúsculas
                return $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                    });
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->paginate(12);

        $categories = Category::where('is_active', 1)->get(); // Para el filtro de categorías

        return view('elements.index', [
            'elements' => $elements,
            'categories' => $categories,
        ]);
    }



    public function create()
    {

        $categories = Category::where('is_active', true)->get();
        //return dd($categories);

        return view('elements.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:300',
            'category_id' => 'required|integer'
        ]);

        //Category::create($request->all());
        Element::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id

        ]);

        return redirect()->route('elements.index')->with('message', 'Categoría creada exitosamente.');
    }
    public function show(Element $element)
    {
        // Verificar si el elemento está activo
        if (!$element->is_active) {
            abort(404);
            //return redirect()->route('elements.index')->with('error', 'El elemento no está activo.');
        }
        return view('elements.show', ['element' => $element]);
    }
    public function edit(Element $element)
    {

        // Verificar si el elemento está activo
        if (!$element->is_active) {
            abort(404);
        }
        $categories = Category::where('is_active', true)->get();
        return view('elements.edit', ['element' => $element, 'categories' => $categories]);
    }

    public function update(Request $request, Element $element)
    {
         // Verificar si el elemento está activo
         if (!$element->is_active) {
            abort(404);
        }

        $validate = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:300',
            'category_id' => 'required|integer'
        ]);
        $element->update($validate);
        return redirect()->route('elements.index')->with('message', 'Elemento actualizado exitosamente.');
    }
    public function destroy(Element $element)
    {
        //$element->delete();
        $element->is_active = false;
        $element->save();
        return redirect()->route('elements.index')->with('message', 'Elemento eliminado exitosamente.');
    }
}
