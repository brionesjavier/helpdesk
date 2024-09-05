<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Element;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        //$categories = Category::get();
        $categories = Category::paginate(3);

        return view('categories.index', compact('categories'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'required|string|max:300'
        ]);

        //Category::create($request->all());
        Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('categories.index')->with('message', 'Categoría creada exitosamente.');

    
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     */
 /*    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'required|string|max:300',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index') ;
    } */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'required|string|max:300',
        ]);
    
        if (!$category->update($validated)) {
            return redirect()->back()->withErrors(['message' => 'No se pudo actualizar la categoría']);
        }
    
        return redirect()->route('categories.index')->with('message', 'Categoría actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        $category->delete();
        return redirect()->route('categories.index') ->with('message', ' Categoria eliminada correctamente!');

    }

/*     public function getElements( Category $category)
    {
        
        $elements = Element::where('category_id', $category->id)->get();
        return response()->json($elements);
    } */

    //chatgpt
    public function getElements($categoryId)
    {
        $elements = Element::where('category_id', $categoryId)
        ->where('is_active',true)
        ->get();
        return response()->json($elements);
    }
}


