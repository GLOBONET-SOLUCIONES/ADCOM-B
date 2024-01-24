<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;
use App\Models\Configuracion\Relacione;

class RelacioneController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // $adminPropiedades = Condominio::where('user_id', $user->admin_id)->get();
        // // Verifica si el 'adminPropiedades' pertenece a una de las propiedades del administrador
        // $propiedad = $adminPropiedades->find($request->condominio_id);
        
        // if (!$propiedad) {
        //     return response()->json(['message' => 'Debe seleccionar una Propiedad.'], 403);
        // }
        
        
        // $relFamiliares = Relacione::where('condominio_id', $propiedad->id)
        //     ->where('user_id', $user->admin_id)
        //     ->orderBy('id', 'desc')->get();

        $relFamiliares = Relacione::where('user_id', $user->admin_id)->get();

        return response()->json([
            'relFamiliares' => $relFamiliares
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // $adminPropiedades = Condominio::where('user_id', $user->admin_id)->get();
        
        // // Verifica si el 'adminPropiedades' pertenece a una de las propiedades del administrador
        // $propiedad = $adminPropiedades->find($request->condominio_id);

        // if (!$propiedad) {
        //     return response()->json(['message' => 'Debe seleccionar una Propiedad.'], 403);
        // }

        $this->validate($request, [
            'relacion' => 'required',
        ]);


        if ($request->id) {
            $relFamiliares = Relacione::find($request->id);
        } else {
            $relFamiliares = new Relacione();
        }

        $relFamiliares->user_id = $user->admin_id;
        $relFamiliares->relacion = $request->relacion;

        $relFamiliares->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'relFamiliares' => $relFamiliares,
        ]);
    }

    public function show(string $id)
    {
        $relFamiliares = Relacione::find($id);

        return response()->json([
            'relFamiliares' => $relFamiliares
        ]);
    }

    public function destroy(string $id)
    {
        $relFamiliares = Relacione::find($id);
        $relFamiliares->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'relFamiliares' => $relFamiliares
        ]);
    }
}
