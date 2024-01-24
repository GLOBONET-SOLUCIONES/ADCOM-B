<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;
use App\Models\Configuracion\PresidenteTesorero;

class PresidenteTesoreroController extends Controller
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
        
        $namePresiTeso = PresidenteTesorero::where('condominio_id', $propiedad->id)
            ->where('user_id', $user->admin_id)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'namePresiTeso' => $namePresiTeso
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
            'condominio_id' => 'required',
            'name_presidente' => 'nullable|string|max:200',
            'name_tesorero' => 'nullable|string|max:200',
        ]);


        if ($request->id) {
            $namePresiTeso = PresidenteTesorero::find($request->id);
        } else {
            
            $dataExist = PresidenteTesorero::where('user_id', $user->admin_id)
                ->where('condominio_id', $request->condominio_id)
                ->first();

            if ($dataExist) {
                return response()->json(['message' => 'Ya existe un Presidente o Tesorero para la Propiedad ' . $propiedad->name_condominio . ', edite la información.'], 403);
            }

            $namePresiTeso = new PresidenteTesorero();
        }

        $namePresiTeso->user_id = $user->admin_id;
        $namePresiTeso->condominio_id = $request->condominio_id;
        $namePresiTeso->name_presidente = $request->name_presidente;
        $namePresiTeso->name_tesorero = $request->name_tesorero;


        $namePresiTeso->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'namePresiTeso' => $namePresiTeso,
        ]);
    }

    public function show(string $id)
    {
        $namePresiTeso = PresidenteTesorero::find($id);

        return response()->json([
            'namePresiTeso' => $namePresiTeso
        ]);
    }

    public function destroy(string $id)
    {
        $namePresiTeso = PresidenteTesorero::find($id);
        $namePresiTeso->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'namePresiTeso' => $namePresiTeso
        ]);
    }
}
