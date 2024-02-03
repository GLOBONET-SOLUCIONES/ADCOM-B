<?php

namespace App\Http\Controllers\Administracion\Publicidad;

use App\Http\Controllers\Controller;
use App\Models\Publicidad\DosPublicidade;
use Illuminate\Http\Request;

class DosPublicidadController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Lamada a los dospublicidad en orden
        $dospublicidad = DosPublicidade::where('user_id', $user->admin_id)->orderBy('id', 'desc')->get();

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
            $dospublicidad = DosPublicidade::find($request->id);
        } else {
            $dospublicidad = new DosPublicidade();
        }


        if ($user->name !== 'SuperAdmin') {

            return response()->json(['message' => 'No tiene permiso para registrar'], 401);
        } else {
            $dospublicidad->user_id = $user->admin_id;

            if ($request->hasFile('publicidad_1')) {

                $publicidades_1 = $request->file('publicidad_1')->store('publicidad/2publicidad', 'public');
                $dospublicidad->publicidad_1 = $publicidades_1;
            }
            if ($request->hasFile('publicidad_2')) {

                $publicidades_2 = $request->file('publicidad_2')->store('publicidad/2publicidad', 'public');
                $dospublicidad->publicidad_2 = $publicidades_2;
            }
            if ($request->hasFile('publicidad_3')) {

                $publicidades_3 = $request->file('publicidad_3')->store('publicidad/2publicidad', 'public');
                $dospublicidad->publicidad_3 = $publicidades_3;
            }
            if ($request->hasFile('publicidad_4')) {

                $publicidades_4 = $request->file('publicidad_4')->store('publicidad/2publicidad', 'public');
                $dospublicidad->publicidad_4 = $publicidades_4;
            }
            if ($request->hasFile('publicidad_5')) {

                $publicidades_5 = $request->file('publicidad_5')->store('publicidad/2publicidad', 'public');
                $dospublicidad->publicidad_5 = $publicidades_5;
            }
            $dospublicidad->tiempo_publicidad = $request->tiempo_publicidad;
            $dospublicidad->save();

            return response()->json([
                'message' => 'El registro ha sido guardado correctamente',
                'dospublicidad' => $dospublicidad,
            ]);
        }
    }

    public function show(string $id)
    {
        $dospublicidad = DosPublicidade::find($id);

        return response()->json([
            'dospublicidad' => $dospublicidad
        ]);
    }



    public function destroy(string $id)
    {
        $dospublicidad = DosPublicidade::find($id);
        $dospublicidad->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'dospublicidad' => $dospublicidad
        ]);
    }
}
