<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Lamada a los usuarios en orden
        $users = User::with('roles')->orderBy('id','desc')->get();

        return response()->json([
            'users' => $users
        ]);
       
      
    }

    public function recursos()
    {
        $user = auth()->user();
        $roles =  DB::table('roles')->orderBy('name','asc')->get();
        
        return response()->json([
            'roles' => $roles,
        ]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'ci_ruc' => 'required|min:10|max:13',
            'email' => 'required|email|max:100',
            'telefono' => 'required|max:10',
            'obligado' => 'required|in:SI,NO',
            'ruc_contador' => 'nullable|max:13',
            'nombre_contador' => 'nullable|max:255',
            'password' => 'required|min:5',
            'role_id' => 'required',
            'plan_id' => 'required',
        ]);

        if($request->id){

            $user = User::find($request->id);
        }else{

            $user = new User;
        }

        if (Auth::user()->hasRole('SuperAdmin')) {

            $plan = Plan::find($request->plan_id);

            // Verificar si se encontró el plan
            if (!$plan) {

                return response()->json(['message' => 'El plan no existe'], 404);
            } else {

                $role = DB::table('roles')->where('id', $request->role_id)->first();
                
                if (!$role) {
                    return response()->json(['message' => 'El role no existe'], 404);
                }


                if ($user->plan_act != $request->plan_id) {
                    
                    $user->plan_ant = $user->plan_act;
                    $user->plan = $plan->nombre;
                    $user->plan_act = $request->plan_id;
                } else {

                    $user->plan_ant = $user->plan_ant;
                    $user->plan_act = $user->plan_act;
                    $user->plan = $user->plan;
                }
                
                
                $user->name = $request->name;
                $user->ci_ruc = $request->ci_ruc;
                $user->telefono = $request->telefono;
                $user->obligado = $request->obligado;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);

                $user->fecha_inicio = now();

                // Calcula la fecha de expiracion basada en la licencia
                $fecha_inicio = $user->fecha_inicio;
                
                if ($plan->licencia === 'Mensual') {
                    $expira = Carbon::parse($fecha_inicio)->addMonth();

                } elseif ($plan->licencia === 'Anual') {
                    $expira = Carbon::parse($fecha_inicio)->addYear();

                } elseif ($plan->licencia === 'Permanente') {
                    $expira = null;
                }

                $user->fecha_final = $expira;
                $user->lim_condominios = $plan->lim_condominios;
                $user->lim_subusuarios = $plan->lim_subusuarios;
                $user->assignRole($role->name);



                $user->save();
            }

            return response()->json([
                'message' => 'El usuario ha sido guardado exitosamente',
                'user' => $user,
            ]);

        } else {

            return response()->json(['message' => 'No tiene los permisos necesarios'], 401);
        }
    }

   public function show(string $id)
    {
        $user = User::find($id);

        return response()->json([
            'user' => $user
        ]);
    }



    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();


        return response()->json([
            'message' => 'El usuario ha sido eliminado correctamente',
            'user' => $user
        ]);
    }
}
