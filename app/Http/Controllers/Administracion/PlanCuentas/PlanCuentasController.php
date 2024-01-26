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

        //         public function store(Request $request)
        // {
        //     // ... (código previo)

        //     $lastPlanCuenta = <link>PlanCuenta</link>::orderBy('id', 'desc')->first(); // Obtener el último registro de <link>PlanCuenta</link>

        //     if ($lastPlanCuenta) {
        //         if ($lastPlanCuenta->cuenta_superior == 0) {
        //             $request->merge(['cuenta_superior' => 1]); // Si el campo cuenta_superior del último registro es 0, cambia a 1
        //         } else {
        //             $lastPlanCuenta->cuenta_superior = 0; // Si el campo cuenta_superior del último registro es 1, cámbialo a 0
        //             $lastPlanCuenta->save();
        //         }
        //     }

        //     $this->validate($request, [
        //         'condominio_id' => 'required',
        //         'codigo' => 'required',
        //         'nombre_cuenta' => 'required',
        //         'grupo_contable' => 'required|in:ACTIVO,PASIVO,PATRIMONIO,INGRESOS,EGRESOS,GASTOS',
        //         'cuenta_superior' => 'required',
        //         'superior_id' => 'required',
        //         'saldo_actual' => 'required',
        //     ]);

        //     // Resto del código para guardar el registro
        // }
        $user = auth()->user();

        $adminPropiedades = Condominio::where('user_id', $user->admin_id)->get();

        // Verifica si el 'adminPropiedades' pertenece a una de las propiedades del administrador
        $propiedad = $adminPropiedades->find($request->condominio_id);

        if (!$propiedad) {
            return response()->json(['message' => 'Debe seleccionar una Propiedad.'], 403);
        }

        $this->validate($request, [
            'condominio_id' => 'required',
            'codigo' => 'required',
            'nombre_cuenta' => 'required',
            'grupo_contable' => 'required|in:ACTIVO,PASIVO,PATRIMONIO,INGRESOS,EGRESOS,GASTOS',
            'cuenta_superior' => 'required',
            'superior_id' => 'required',
            'saldo_actual' => 'required',

        ]);

        if ($request->id) {
            $plancuentas = PlanCuenta::find($request->id);
        } else {
            $plancuentas = new PlanCuenta();
        }


        // $planCuentasResponse = $this->index($request);
        // $planCuentas = $planCuentasResponse->original['plancuentas'];

        // foreach ($planCuentas as $plancuenta) {
        //     $condominioId = $plancuenta->codigo;
        // }
        // dd($condominioId);

        // $relaciones = Relacione::where('id', $request->relacion_propietario);

        $plancuentas->user_id = $user->admin_id;
        $plancuentas->condominio_id = $request->condominio_id;
        $plancuentas->codigo = $request->codigo;
        $plancuentas->nombre_cuenta = $request->nombre_cuenta;
        $plancuentas->grupo_contable = $request->grupo_contable;
        $plancuentas->cuenta_superior = $request->cuenta_superior;
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
        $plancuentas->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'plancuen$plancuentas' => $plancuentas
        ]);
    }
}
