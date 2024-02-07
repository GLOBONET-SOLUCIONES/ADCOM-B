<?php

namespace App\Http\Controllers\Administracion\Publicidad;

use App\Http\Controllers\Controller;
use App\Models\Publicidad\UnoPublicidade;
use Illuminate\Http\Request;

class UnoPublicidadControlller extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Lamada a los unopublicidad en orden
        $unopublicidad = UnoPublicidade::where('user_id', $user->admin_id)->orderBy('id', 'desc')->get();

        return response()->json([
            'unopublicidad' => $unopublicidad
        ]);
    }



    public function store(Request $request)
    {
        $user = auth()->user();


        $this->validate($request, [
            'publicidad_1' => 'required|image|mimes:jpeg,png,gif,jpg',
            'publicidad_2' => 'nullable|image|mimes:jpeg,png,gif,jpg',
            'publicidad_3' => 'nullable|image|mimes:jpeg,png,gif,jpg',
            'publicidad_4' => 'nullable|image|mimes:jpeg,png,gif,jpg',
            'publicidad_5' => 'nullable|image|mimes:jpeg,png,gif,jpg',
            'tiempo_publicidad' => 'nullable',


        ]);



        if ($request->id) {
            $unopublicidad = UnoPublicidade::find($request->id);
        } else {
            $unopublicidad = new UnoPublicidade();
        }


        if ($user->name !== 'SuperAdmin') {

            return response()->json(['message' => 'No tiene permiso para registrar'], 401);
        } else {
            $unopublicidad->user_id = $user->admin_id;

            if ($request->hasFile('publicidad_1')) {

                $publicidades_1 = $request->file('publicidad_1')->store('publicidad/1publicidad', 'public');
                $unopublicidad->publicidad_1 = $publicidades_1;
            }
            if ($request->hasFile('publicidad_2')) {

                $publicidades_2 = $request->file('publicidad_2')->store('publicidad/1publicidad', 'public');
                $unopublicidad->publicidad_2 = $publicidades_2;
            }
            if ($request->hasFile('publicidad_3')) {

                $publicidades_3 = $request->file('publicidad_3')->store('publicidad/1publicidad', 'public');
                $unopublicidad->publicidad_3 = $publicidades_3;
            }
            if ($request->hasFile('publicidad_4')) {

                $publicidades_4 = $request->file('publicidad_4')->store('publicidad/1publicidad', 'public');
                $unopublicidad->publicidad_4 = $publicidades_4;
            }
            if ($request->hasFile('publicidad_5')) {

                $publicidades_5 = $request->file('publicidad_5')->store('publicidad/1publicidad', 'public');
                $unopublicidad->publicidad_5 = $publicidades_5;
            }
            $unopublicidad->tiempo_publicidad = $request->tiempo_publicidad;
            $unopublicidad->save();

            return response()->json([
                'message' => 'El registro ha sido guardado correctamente',
                'unopublicidad' => $unopublicidad,
            ]);
        }
    }

    public function show(string $id)
    {
        $unopublicidad = UnoPublicidade::find($id);

        return response()->json([
            'unopublicidad' => $unopublicidad
        ]);
    }



    public function destroy(string $id)
    {
        $unopublicidad = UnoPublicidade::find($id);
        $unopublicidad->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'unopublicidad' => $unopublicidad
        ]);
    }
}
