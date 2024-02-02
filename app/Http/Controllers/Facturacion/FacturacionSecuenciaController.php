<?php

namespace App\Http\Controllers\Facturacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;
use App\Models\Facturacion\FacturacionSecuencia;

class FacturacionSecuenciaController extends Controller
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

        $secFacturacion = FacturacionSecuencia::where('condominio_id', $propiedad->id)
            ->where('user_id', $user->admin_id)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'secFacturacion' => $secFacturacion
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
            'establecimiento' => 'required|max:3',
            'punto_emision' => 'required|max:3',
            'sec_factura' => 'required|max:9',
            'sec_retencion' => 'required|max:9',
            'sec_nota_credito' => 'required|max:9',
            'sec_nota_debito' => 'required|max:9',
            'sec_guia_remision' => 'required|max:9',
            'sec_liquidacion_compra' => 'required|max:9',
        ]);


        if ($request->id) {

            $secFacturacion = FacturacionSecuencia::find($request->id);
        } else {
            
            $existSecuencia = FacturacionSecuencia::where('condominio_id', $request->condominio_id)->first();

            if ($existSecuencia && !$request->id) {
                return response()->json(['message' => 'Ya existe una secuencia de facturación para la propiedad ' . $propiedad->name_condominio . ', edite la información.'], 403);
            }

            $secFacturacion = new FacturacionSecuencia();
        }

        $secFacturacion->user_id = $user->admin_id;
        $secFacturacion->condominio_id = $request->condominio_id;
        $secFacturacion->establecimiento = $request->establecimiento;
        $secFacturacion->punto_emision = $request->punto_emision;
        $secFacturacion->sec_factura = str_pad($request->sec_factura, 9, "0", STR_PAD_LEFT);
        $secFacturacion->sec_retencion = str_pad($request->sec_retencion, 9, "0", STR_PAD_LEFT);
        $secFacturacion->sec_nota_credito = str_pad($request->sec_nota_credito, 9, "0", STR_PAD_LEFT);
        $secFacturacion->sec_nota_debito = str_pad($request->sec_nota_debito, 9, "0", STR_PAD_LEFT);
        $secFacturacion->sec_guia_remision = str_pad($request->sec_guia_remision, 9, "0", STR_PAD_LEFT);
        $secFacturacion->sec_liquidacion_compra = str_pad($request->sec_liquidacion_compra, 9, "0", STR_PAD_LEFT);

        $secFacturacion->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'secFacturacion' => $secFacturacion,
        ]);
    }

    public function show(string $id)
    {
        $secFacturacion = FacturacionSecuencia::find($id);

        return response()->json([
            'secFacturacion' => $secFacturacion
        ]);
    }

    public function destroy(string $id)
    {
        $secFacturacion = FacturacionSecuencia::find($id);
        $secFacturacion->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'secFacturacion' => $secFacturacion
        ]);
    }
}
