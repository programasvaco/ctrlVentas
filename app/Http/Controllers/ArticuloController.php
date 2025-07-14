<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticuloController extends Controller
{
    public function index()
    {
        $articulos = Articulo::all();
        return view('articulos.index', compact('articulos'));
    }

    public function create()
    {
        return view('articulos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'articulo' => 'required|string|max:100',
            'unidad' => 'required|string|max:20',
            'estado' => 'required|in:activo,inactivo',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $request->file('imagen')->store('articulos', 'public');
        }

        Articulo::create($data);

        return redirect()->route('articulos.index')->with('success', 'Artículo creado correctamente.');
    }

    public function show(Articulo $articulo)
    {
        return view('articulos.show', compact('articulo'));
    }

    public function edit(Articulo $articulo)
    {
        return view('articulos.edit', compact('articulo'));
    }

    public function update(Request $request, Articulo $articulo)
    {
        $request->validate([
            'articulo' => 'required|string|max:100',
            'unidad' => 'required|string|max:20',
            'estado' => 'required|in:activo,inactivo',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($articulo->imagen) {
                $oldImage = str_replace('storage/', 'public/', $articulo->imagen);
                Storage::delete($oldImage);
            }

            $imagePath = $request->file('imagen')->store('public/articulos');
            $data['imagen'] = str_replace('public/', 'storage/', $imagePath);
        }

        $articulo->update($data);

        return redirect()->route('articulos.index')->with('success', 'Artículo actualizado correctamente.');
    }

    public function destroy(Articulo $articulo)
    {
        // Eliminar imagen si existe
        if ($articulo->imagen) {
            $imagePath = str_replace('storage/', 'public/', $articulo->imagen);
            Storage::delete($imagePath);
        }

        $articulo->delete();

        return redirect()->route('articulos.index')->with('success', 'Artículo eliminado correctamente.');
    }
}