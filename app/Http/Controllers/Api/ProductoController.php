<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return response()->json(Producto::all(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'activo' => ['sometimes', 'boolean'],
        ]);

        $producto = Producto::create($data);

        return response()->json($producto, 201);
    }

    public function show(Producto $producto)
    {
        return response()->json($producto, 200);
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre' => ['sometimes', 'required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['sometimes', 'required', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'required', 'integer', 'min:0'],
            'activo' => ['sometimes', 'boolean'],
        ]);

        $producto->update($data);

        return response()->json($producto, 200);
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return response()->json([
            'mensaje' => 'Producto eliminado correctamente'
        ], 200);
    }
}