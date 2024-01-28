<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Configuracion\Banco;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;

class BancoController extends Controller
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
        
        $bancos = Banco::where('condominio_id', $propiedad->id)
            ->where('user_id', $user->admin_id)
            ->get();

        return response()->json([
            'bancos' => $bancos
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
            'fecha_registro' => 'required',
            'banco' => 'required|string',
            'cuenta' => 'required|string',
            'saldo_inicial' => 'required',
            'predeterminado' => 'required|in:SI,NO',
        ]);


        if ($request->id) {
            $bancos = Banco::find($request->id);
        } else {
            $bancos = new Banco();
        }

        if ($request->predeterminado == 'SI') {
            // Verificar si el banco actual ya está marcado como predeterminado
            if ($bancos->predeterminado != 'SI') {
                // Actualizar cualquier banco predeterminado existente a "NO" para esta propiedad
                Banco::where('condominio_id', $request->condominio_id)
                     ->where('predeterminado', 'SI')
                     ->where('id', '!=', $bancos->id) // No incluir el banco actual en la actualización
                     ->update(['predeterminado' => 'NO']);
            }
        }

        $bancos->user_id = $user->admin_id;
        $bancos->condominio_id = $request->condominio_id;
        $bancos->fecha_registro = Carbon::createFromFormat('d/m/Y', $request->fecha_registro)->format('Y-m-d');
        $bancos->banco = $request->banco;
        $bancos->cuenta = $request->cuenta;
        $bancos->saldo_inicial = $request->saldo_inicial;
        $bancos->predeterminado = $request->predeterminado;

        $bancos->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'bancos' => $bancos,
        ]);
    }

    public function show(string $id)
    {
        $bancos = Banco::find($id);

        return response()->json([
            'bancos' => $bancos
        ]);
    }

    public function destroy(string $id)
    {
        $bancos = Banco::find($id);
        $bancos->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'bancos' => $bancos
        ]);
    }
}
