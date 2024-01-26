<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;
use App\Models\Configuracion\Proveedore;

class ProveedoreController extends Controller
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
        
        $proveedores = Proveedore::where('condominio_id', $propiedad->id)
            ->where('user_id', $user->admin_id)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'proveedores' => $proveedores
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
            'razon_social' => 'required|string|max:200',
            'calle_principal' => 'required|string|max:200',
            'numero' => 'required|string|max:200',
            'calle_secundaria' => 'nullable|string|max:200',
            'telefono' => 'nullable|min:9',
            'celular' => 'nullable|min:10',
            'email' => 'nullable|email',
            'fecha_ingreso' => 'nullable',
            'fecha_inactivo' => 'nullable',
            'name_contacto' => 'nullable',
            'telefono_contacto' => 'nullable',
            'inactivo' => 'nullable|in:SI,NO',
            'motivo' => 'nullable',
        ]);


        if ($request->id) {
            $proveedores = Proveedore::find($request->id);
        } else {
            
            $proveedores = new Proveedore();
        }

        $proveedores->user_id = $user->admin_id;
        $proveedores->condominio_id = $request->condominio_id;
        $proveedores->ci_ruc = $request->ci_ruc;
        $proveedores->razon_social = $request->razon_social;
        $proveedores->calle_principal = $request->calle_principal;
        $proveedores->numero = $request->numero;
        $proveedores->calle_secundaria = $request->calle_secundaria;
        $proveedores->telefono = $request->telefono;
        $proveedores->celular = $request->celular;
        $proveedores->email = $request->email;
        $proveedores->fecha_ingreso = Carbon::createFromFormat('d/m/Y', $request->fecha_ingreso)->format('Y-m-d');
        $proveedores->name_contacto = $request->name_contacto;
        $proveedores->telefono_contacto = $request->telefono_contacto;
        $proveedores->inactivo = $request->inactivo;
        
        if ($proveedores->inactivo === 'SI') {
            
            $proveedores->motivo = $request->motivo;
            $proveedores->fecha_inactivo = now();
        } else {
            $proveedores->motivo = null;
            $proveedores->fecha_inactivo = null;
            $proveedores->inactivo = "NO";
        }
        

        $proveedores->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'proveedores' => $proveedores,
        ]);
    }

    public function show(string $id)
    {
        $proveedores = Proveedore::find($id);

        return response()->json([
            'proveedores' => $proveedores
        ]);
    }

    public function destroy(string $id)
    {
        $proveedores = Proveedore::find($id);
        $proveedores->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'proveedores' => $proveedores
        ]);
    }
}
