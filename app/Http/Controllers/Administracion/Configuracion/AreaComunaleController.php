<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;
use App\Models\Configuracion\AreaComunale;

class AreaComunaleController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $adminPropiedades = Condominio::where('user_id', $user->admin_id)->get();
        // Verifica si el 'adminPropiedades' pertenece a una de las propiedades del administrador
        $propiedad = $adminPropiedades->find($request->condominio_id);
        
        if (!$propiedad) {
            return response()->json(['message' => 'Debe seleccionar una Propiedad.'], 403);
        }
        
        $areasComunales = AreaComunale::where('condominio_id', $propiedad->id)
            ->where('user_id', $user->admin_id)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'areasComunales' => $areasComunales
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $adminPropiedades = Condominio::where('user_id', $user->admin_id)->get();
        
        // Verifica si el 'adminPropiedades' pertenece a una de las propiedades del administrador
        $propiedad = $adminPropiedades->find($request->condominio_id);

        if (!$propiedad) {
            return response()->json(['message' => 'Debe seleccionar una Propiedad.'], 403);
        }

        $this->validate($request, [
            'area_comunal' => 'required',
            'condominio_id' => 'required',
        ]);


        if ($request->id) {
            $areasComunales = AreaComunale::find($request->id);
        } else {
            $areasComunales = new AreaComunale();
        }

        $areasComunales->user_id = $user->admin_id;
        $areasComunales->condominio_id = $request->condominio_id;
        $areasComunales->area_comunal = $request->area_comunal;

        $areasComunales->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'areasComunales' => $areasComunales,
        ]);
    }

    public function show(string $id)
    {
        $areasComunales = AreaComunale::find($id);

        return response()->json([
            'areasComunales' => $areasComunales
        ]);
    }

    public function destroy(string $id)
    {
        $areasComunales = AreaComunale::find($id);
        $areasComunales->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'areasComunales' => $areasComunales
        ]);
    }
}
