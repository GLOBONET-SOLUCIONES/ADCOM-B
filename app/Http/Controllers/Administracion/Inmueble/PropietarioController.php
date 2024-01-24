<?php

namespace App\Http\Controllers\Administracion\Inmueble;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Inmueble\Propietario;
use App\Models\Condominios\Condominio;

class PropietarioController extends Controller
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

        $propietarios = Propietario::where('user_id', $user->admin_id)->orderBy('id', 'desc')->get();

        return response()->json([
            'propietarios' => $propietarios
        ]);
    }



    public function store(Request $request)
    {
        $user = auth()->user();


        $this->validate($request, [
            'recibo' => 'nullable',
            'name_propietario' => 'required',
            'ci_propietario' => 'required|max:13',
            'nacimiento_propietario' => 'required',
            'telefono_propietario' => 'nullable',
            'celular_propietario' => 'nullable',
            'email_propietario' => 'required',
            'envio_emailprincipal' => 'nullable',
            'email_secundariopropietario' => 'nullable',
            'envio_emailsecundario' => 'nullable',
        ]);

        if ($request->id) {
            $propietarios = Propietario::find($request->id);
        } else {
            $propietarios = new Propietario();
        }

        // $relaciones = Relacione::where('id', $request->relacion_propietario);


        $propietarios->user_id = $user->admin_id;
        $propietarios->recibo = $request->recibo;
        $propietarios->name_propietario = $request->name_propietario;
        $propietarios->ci_propietario = $request->ci_propietario;
        $propietarios->relacion_propietario = $request->relacion_propietario;
        $propietarios->nacimiento_propietario = Carbon::createFromFormat('d/m/Y', $request->nacimiento_propietario)->format('Y-m-d');
        $propietarios->telefono_propietario = $request->telefono_propietario;
        $propietarios->celular_propietario = $request->celular_propietario;
        $propietarios->email_propietario = $request->email_propietario;
        $propietarios->envio_emailprincipal = $request->envio_emailprincipal;
        $propietarios->email_secundariopropietario = $request->email_secundariopropietario;
        $propietarios->envio_emailsecundario = $request->envio_emailsecundario;

        $propietarios->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'propietarios' => $propietarios,
        ]);
    }

    public function show(string $id)
    {
        $propietarios = Propietario::find($id);

        return response()->json([
            'propietarios' => $propietarios
        ]);
    }



    public function destroy(string $id)
    {
        $condominios = Condominio::find($id);
        $condominios->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'condominios' => $condominios
        ]);
    }
}
