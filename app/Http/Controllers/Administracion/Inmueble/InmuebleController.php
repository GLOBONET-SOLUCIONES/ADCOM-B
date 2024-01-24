<?php

namespace App\Http\Controllers\Administracion\Inmueble;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Inmueble\Inmueble;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;

class InmuebleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $adminPropiedades = Condominio::where('user_id', $user->admin_id)->get();
        // Verifica si el 'adminPropiedades' pertenece a una de las propiedades del administrador
        $propiedad = $adminPropiedades->find($request->condominio_id);

        if (!$propiedad) {
            return response()->json(['message' => 'Debe seleccionar una Propiedad.'], 403);
        }

        // $inmuebles = Inmueble::where('user_id', $user->admin_id)->orderBy('id', 'desc')->get();

        $inmuebles = Inmueble::join('propietarios', 'inmuebles.propietario_id', '=', 'propietarios.id')
            ->join('residentes', 'inmuebles.residente_id', '=', 'residentes.id')
            ->select('inmuebles.*', 'propietarios.name_propietario', 'residentes.name_residente')
            ->get();

        return response()->json([
            'inmuebles' => $inmuebles
        ]);
    }



    public function store(Request $request)
    {
        $user = auth()->user();


        $this->validate($request, [
            'name_inmueble' => 'required',
            'condominio_id' => 'required',
            'plantas' => 'required|integer',
            'alicuotas' => 'required',
            'expensas' => 'required',
            'propietario_id' => 'required',
            'residente_id' => 'nullable',
            'fecha_entrega' => 'nullable',
            'es_residente' => 'required',

        ]);

        if ($request->id) {
            $inmuebles = Inmueble::find($request->id);
        } else {
            $inmuebles = new Inmueble();
        }

        // $relaciones = Relacione::where('id', $request->relacion_propietario);
        $inmuebles->user_id = $user->admin_id;
        $inmuebles->name_inmueble = $request->name_inmueble;
        $inmuebles->condominio_id = $request->condominio_id;
        $inmuebles->plantas = $request->plantas;
        $inmuebles->alicuotas = $request->alicuotas;
        $inmuebles->expensas = $request->expensas;
        $inmuebles->propietario_id = $request->propietario_id;
        $inmuebles->residente_id = $request->residente_id;
        $inmuebles->fecha_entrega = Carbon::createFromFormat('d/m/Y', $request->fecha_entrega)->format('Y-m-d');
        $inmuebles->es_residente = $request->es_residente;
        $inmuebles->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'inmuebles' => $inmuebles,
        ]);
    }


    public function show(string $id)
    {
        $inmuebles = Inmueble::find($id);

        return response()->json([
            'inmuebles$inmuebles' => $inmuebles
        ]);
    }



    public function destroy(string $id)
    {
        $inmuebles = Inmueble::find($id);
        $inmuebles->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'inmuebles' => $inmuebles
        ]);
    }
}
