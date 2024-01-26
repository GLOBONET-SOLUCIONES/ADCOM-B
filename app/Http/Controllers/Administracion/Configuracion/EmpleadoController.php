<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;
use App\Models\Configuracion\Empleado;

class EmpleadoController extends Controller
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
        
        $empleados = Empleado::where('condominio_id', $propiedad->id)
            ->where('user_id', $user->admin_id)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'empleados' => $empleados
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
            'ci_ruc' => 'required|string|min:10|max:13',
            'apellido' => 'required|string|max:200',
            'name' => 'required|string|max:200',
            'calle_principal' => 'required|string|max:200',
            'numero' => 'required|string|max:200',
            'calle_secundaria' => 'nullable|string|max:200',
            'telefono' => 'nullable|min:9',
            'celular' => 'nullable|min:10',
            'email' => 'nullable|email',
            'fecha_ingreso' => 'nullable',
            'fecha_inactivo' => 'nullable',
            'inactivo' => 'nullable|in:SI,NO',
            'motivo' => 'nullable',
        ]);


        if ($request->id) {
            $empleados = Empleado::find($request->id);
        } else {
            
            $empleados = new Empleado();
        }

        $empleados->user_id = $user->admin_id;
        $empleados->condominio_id = $request->condominio_id;
        $empleados->ci_ruc = $request->ci_ruc;
        $empleados->apellido = $request->apellido;
        $empleados->name = $request->name;
        $empleados->calle_principal = $request->calle_principal;
        $empleados->numero = $request->numero;
        $empleados->calle_secundaria = $request->calle_secundaria;
        $empleados->telefono = $request->telefono;
        $empleados->celular = $request->celular;
        $empleados->email = $request->email;
        $empleados->fecha_ingreso = $request->fecha_ingreso;
        $empleados->inactivo = $request->inactivo;
        
        if ($empleados->inactivo === 'SI') {
            
            $empleados->motivo = $request->motivo;
            $empleados->fecha_inactivo = now();
        } else {
            $empleados->motivo = null;
            $empleados->fecha_inactivo = null;
            $empleados->inactivo = "NO";
        }
        

        $empleados->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'empleados' => $empleados,
        ]);
    }

    public function show(string $id)
    {
        $empleados = Empleado::find($id);

        return response()->json([
            'empleados' => $empleados
        ]);
    }

    public function destroy(string $id)
    {
        $empleados = Empleado::find($id);
        $empleados->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'empleados' => $empleados
        ]);
    }
}
