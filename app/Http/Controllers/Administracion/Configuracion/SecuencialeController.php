<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;
use App\Models\Configuracion\Secuenciale;
use Illuminate\Http\Request;

class SecuencialeController extends Controller
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

        $secDocumentos = Secuenciale::where('condominio_id', $propiedad->id)
            ->where('user_id', $user->admin_id)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'secDocumentos' => $secDocumentos
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
            'secIngreso' => 'required|max:9',
            'secEgreso' => 'required|max:9',
            'secEntregaInv' => 'required|max:9',
            'secNotaCredito' => 'required|max:9',
        ]);


        if ($request->id) {

            $secDocumentos = Secuenciale::find($request->id);
        } else {
            
            $existSecuencia = Secuenciale::where('condominio_id', $request->condominio_id)->first();

            if ($existSecuencia && !$request->id) {
                return response()->json(['message' => 'Ya existe una secuencia para esta propiedad, edite la información.'], 403);
            }

            $secDocumentos = new Secuenciale();
        }

        $secDocumentos->user_id = $user->admin_id;
        $secDocumentos->condominio_id = $request->condominio_id;
        $secDocumentos->secIngreso = str_pad($request->secIngreso, 9, "0", STR_PAD_LEFT);
        $secDocumentos->secEgreso = str_pad($request->secEgreso, 9, "0", STR_PAD_LEFT);
        $secDocumentos->secEntregaInv = str_pad($request->secEntregaInv, 9, "0", STR_PAD_LEFT);
        $secDocumentos->secNotaCredito = str_pad($request->secNotaCredito, 9, "0", STR_PAD_LEFT);

        $secDocumentos->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'secDocumentos' => $secDocumentos,
        ]);
    }

    public function show(string $id)
    {
        $secDocumentos = Secuenciale::find($id);

        return response()->json([
            'secDocumentos' => $secDocumentos
        ]);
    }

    public function destroy(string $id)
    {
        $secDocumentos = Secuenciale::find($id);
        $secDocumentos->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'secDocumentos' => $secDocumentos
        ]);
    }
}
