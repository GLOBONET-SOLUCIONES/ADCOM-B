<?php

namespace App\Http\Controllers\Administracion\Publicidad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Publicidad\DosPublicidade;
use App\Models\Publicidad\TresPublicidade;

class TresPublicidadController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Lamada a los dospublicidad en orden
        $dospublicidad = TresPublicidade::where('user_id', $user->admin_id)->orderBy('id', 'desc')->get();

        return response()->json([
            'dospublicidad' => $dospublicidad
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
            $trespublicidad = TresPublicidade::find($request->id);
        } else {
            $trespublicidad = new TresPublicidade();
        }


        if ($user->name !== 'SuperAdmin') {

            return response()->json(['message' => 'No tiene permiso para registrar'], 401);
        } else {
            $trespublicidad->user_id = $user->admin_id;

            if ($request->hasFile('publicidad_1')) {

                $publicidades_1 = $request->file('publicidad_1')->store('publicidad/3publicidad', 'public');
                $trespublicidad->publicidad_1 = $publicidades_1;
            }
            if ($request->hasFile('publicidad_2')) {

                $publicidades_2 = $request->file('publicidad_2')->store('publicidad/3publicidad', 'public');
                $trespublicidad->publicidad_2 = $publicidades_2;
            }
            if ($request->hasFile('publicidad_3')) {

                $publicidades_3 = $request->file('publicidad_3')->store('publicidad/3publicidad', 'public');
                $trespublicidad->publicidad_3 = $publicidades_3;
            }
            if ($request->hasFile('publicidad_4')) {

                $publicidades_4 = $request->file('publicidad_4')->store('publicidad/3publicidad', 'public');
                $trespublicidad->publicidad_4 = $publicidades_4;
            }
            if ($request->hasFile('publicidad_5')) {

                $publicidades_5 = $request->file('publicidad_5')->store('publicidad/3publicidad', 'public');
                $trespublicidad->publicidad_5 = $publicidades_5;
            }
            $trespublicidad->tiempo_publicidad = $request->tiempo_publicidad;
            $trespublicidad->save();

            return response()->json([
                'message' => 'El registro ha sido guardado correctamente',
                'trespublicidad' => $trespublicidad,
            ]);
        }
    }

    public function show(string $id)
    {
        $trespublicidad = TresPublicidade::find($id);

        return response()->json([
            'trespublicidad' => $trespublicidad
        ]);
    }



    public function destroy(string $id)
    {
        $trespublicidad = TresPublicidade::find($id);
        $trespublicidad->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'trespublicidad' => $trespublicidad
        ]);
    }
}
