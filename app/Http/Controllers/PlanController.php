<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $planes = Plan::where('user_id', $user->id)->orderBy('id','desc')->get();

        return response()->json([
            'planes' => $planes
        ]);
    }

    public function store(Request $request)
    {
    
        $this->validate($request, [
            'nombre' => 'required|string|max:255',
            'licencia' => 'required|in:Mensual,Anual,Permanente',
            'lim_condominios' => 'required|integer',
            'lim_subusuarios' => 'required|integer',
            'precio' => 'required',
        ]);

        // Obtener el ID del usuario autenticado que esta creando el plan
        $user = auth()->user();

        if ($user->hasRole('SuperAdmin')) {
            
            if(@$request->id){

                $plan = Plan::find($request->id);
            }else{

                $plan = new Plan;
            }

            $plan->nombre = $request->nombre;
            $plan->licencia = $request->licencia;
            $plan->lim_condominios = $request->lim_condominios;
            $plan->lim_subusuarios = $request->lim_subusuarios;
            $plan->precio = $request->precio;

            $plan->save();

            return response()->json([
                'message' => 'El registro ha sido guardado exitosamente',
                'plan' => $plan
            ]);

        } else {
            
            return response()->json(['message' => 'No autorizado'], 401);
        }
    }

    public function show(string $id)
    {
        $plan = Plan::find($id);

        return response()->json([
            'plan' => $plan
        ]);
    }

    public function destroy(Plan $plan)
    {
        // Obtenemos el ID del usuario autenticado y el ID de la plan que nos pasan por la URL
        $user = auth()->user();
        $planId = $plan->id;
        

        if ($user->hasRole('SuperAdmin')) {

            // Recuperamos la plan específica asociada al usuario autenticado y con el ID proporcionado
            $plan = Plan::where('id', $planId)->first();

            // Eliminamos la plan
            $plan->delete();

            return response()->json([
                'message' => 'El registro ha sido eliminado exitosamente',
                'plan' => $plan
            ]);
        } else {
            
            return response()->json(['message' => 'No autorizado'], 401);
        }
    }
}
