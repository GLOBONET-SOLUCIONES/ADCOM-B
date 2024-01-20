<?php

namespace App\Http\Controllers\Administracion\Inmueble;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Inmueble\Residente;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;

class ResidenteController extends Controller
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

        $residentes = Residente::where('user_id', $user->admin_id)->orderBy('id', 'desc')->get();

        return response()->json([
            'residentes' => $residentes
        ]);
    }


    public function store(Request $request)
    {
        $user = auth()->user();


        $this->validate($request, [
            'recibo' => 'nullable',
            'name_residente' => 'required',
            'ci_residente' => 'required|max:13',
            'nacimiento_residente' => 'required',
            'telefono_residente' => 'nullable',
            'celular_residente' => 'nullable',
            'email_residente' => 'required',
            'envio_emailprincipal' => 'nullable',
            'email_secundarioresidente' => 'nullable',
            'envio_emailsecundario' => 'nullable',
        ]);

        if ($request->id) {
            $residentes = Residente::find($request->id);
        } else {
            $residentes = new Residente();
        }

        // $relaciones = Relacione::where('id', $request->relacion_propietario);

        $residentes->user_id = $user->admin_id;
        $residentes->recibo = $request->recibo;
        $residentes->name_residente = $request->name_residente;
        $residentes->ci_residente = $request->ci_residente;
        $residentes->relacion_residente = $request->relacion_residente;
        $residentes->nacimiento_residente = Carbon::createFromFormat('d/m/Y', $request->nacimiento_residente)->format('Y-m-d');
        $residentes->telefono_residente = $request->telefono_residente;
        $residentes->celular_residente = $request->celular_residente;
        $residentes->email_residente = $request->email_residente;
        $residentes->envio_emailprincipal = $request->envio_emailprincipal;
        $residentes->email_secundarioresidente = $request->email_secundarioresidente;
        $residentes->envio_emailsecundario = $request->envio_emailsecundario;

        $residentes->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'residentes' => $residentes,
        ]);
    }

    public function show(string $id)
    {
        $residentes = Residente::find($id);

        return response()->json([
            'residentes' => $residentes
        ]);
    }



    public function destroy(string $id)
    {
        $residentes = Residente::find($id);
        $residentes->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'residentes' => $residentes
        ]);
    }
}
