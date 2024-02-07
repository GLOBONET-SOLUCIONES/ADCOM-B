<?php

namespace App\Http\Controllers\Finanzas\Inventario;

use App\Http\Controllers\Controller;
use App\Models\Finanzas\Inventario\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Lamada a los inventarios en orden
        $inventarios = Inventario::where('user_id', $user->admin_id)->orderBy('id', 'desc')->get();

        return response()->json([
            'inventarios' => $inventarios
        ]);
    }



    public function store(Request $request)
    {
        $user = auth()->user();


        $this->validate($request, [
            'codigo' => 'required|max:25',
            'name' => 'required|max:100',
            'marca' => 'nullable',
            'unidad_medida' => 'nullable',
            'stock' => 'nullable',

        ]);

        if ($request->id) {
            $inventarios = Inventario::find($request->id);
        } else {
            $inventarios = new Inventario();
        }

        // $relaciones = Relacione::where('id', $request->relacion_propietario);
        $inventarios->user_id = $user->admin_id;
        $inventarios->codigo = $request->codigo;
        $inventarios->name = $request->name;
        $inventarios->marca = $request->marca;
        $inventarios->unidad_medida = $request->unidad_medida;
        $inventarios->stock = $request->stock;
        $inventarios->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'inventarios' => $inventarios,
        ]);
    }


    public function show(string $id)
    {
        $inventarios = Inventario::find($id);

        return response()->json([
            'inventarios' => $inventarios
        ]);
    }



    public function destroy(string $id)
    {
        $inventarios = Inventario::find($id);
        $inventarios->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'inventarios' => $inventarios
        ]);
    }
}
