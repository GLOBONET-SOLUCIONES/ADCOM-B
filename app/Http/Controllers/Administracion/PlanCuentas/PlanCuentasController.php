<?php

namespace App\Http\Controllers\Administracion\PlanCuentas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;
use App\Models\Plancuentas\PlanCuenta;

class PlanCuentasController extends Controller
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

        $plancuentas = PlanCuenta::where('condominio_id', $propiedad->id)
            ->where('user_id', $user->admin_id)
            ->get();

        return response()->json([
            'plancuentas' => $plancuentas
        ]);
    }



    public function store(Request $request)
    {
        $user = auth()->user();

        $adminPropiedades = Condominio::where('user_id', $user->admin_id)->get();

        // Verifica si 'adminPropiedades' pertenece a una de las propiedades del administrador
        $propiedad = $adminPropiedades->find($request->condominio_id);

        if (!$propiedad) {
            return response()->json(['message' => 'Debe seleccionar una Propiedad.'], 403);
        }

        $this->validate($request, [
            'condominio_id' => 'required',
            'codigo' => 'required',
            'nombre_cuenta' => 'required',
            'grupo_contable' => 'required|in:ACTIVO,PASIVO,PATRIMONIO,INGRESOS,EGRESOS,GASTOS',
            'cuenta_superior' => 'nullable',
            'superior_id' => 'nullable',
            'saldo_actual' => 'required',
        ]);

        // Obtener el registro seleccionado
        $registroSeleccionado = PlanCuenta::find($request->superior_id);

        if ($registroSeleccionado->cuenta_superior == 0) {
            // Si cuenta_superior es 0 en el registro seleccionado, establecer cuenta_superior = 1 en el nuevo registro
            $request->merge(['cuenta_superior' => 1]);
        } else {
            // Si cuenta_superior es 1 en el registro seleccionado, invertir cuenta_superior y ajustar en ambos registros
            $registroSeleccionado->cuenta_superior = 0;
            $registroSeleccionado->save();
            $request->merge(['cuenta_superior' => 1]);
        }

        if ($request->id) {
            $plancuentas = PlanCuenta::find($request->id);
        } else {
            $plancuentas = new PlanCuenta();
        }


        if ($registroSeleccionado->cuenta_superior == 0) {

            $plancuentas->cuenta_superior = 1;
            // dd($cuentaSuperior);

        } else {

            $registroSeleccionado->cuenta_superior = 0;
            $registroSeleccionado->save();
            $plancuentas->cuenta_superior = 1;
        }

        $plancuentas->user_id = $user->admin_id;
        $plancuentas->condominio_id = $request->condominio_id;
        $plancuentas->codigo = $request->codigo;
        $plancuentas->nombre_cuenta = $request->nombre_cuenta;
        $plancuentas->grupo_contable = $request->grupo_contable;
        // $plancuentas->cuenta_superior = $$plancuentas->cuenta_superior;
        $plancuentas->superior_id = $registroSeleccionado->id;
        $plancuentas->saldo_actual = $request->saldo_actual;
        $plancuentas->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'plancuentas' => $plancuentas,
        ]);
    }



    public function show(string $id)
    {
        $plancuentas = PlanCuenta::find($id);

        return response()->json([
            'plancuentas' => $plancuentas
        ]);
    }





    public function destroy(string $id)
    {

        $plancuentas = PlanCuenta::find($id);


        if ($plancuentas) {

            $superiorId = $plancuentas->superior_id;


            $plancuentas->delete();


            $registroSuperior = PlanCuenta::where('id', $superiorId)->first();


            if ($registroSuperior) {

                $registroSuperior->cuenta_superior = 0;
                $registroSuperior->save();
            }

            return response()->json([
                'message' => 'El registro ha sido eliminado correctamente',
                'plancuentas' => $plancuentas
            ]);
        } else {
            return response()->json([
                'message' => 'No se encontró el registro a eliminar'
            ], 404);
        }
    }
}
