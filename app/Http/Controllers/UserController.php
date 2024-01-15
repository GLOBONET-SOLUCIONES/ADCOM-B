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
        $userId = auth()->user()->id;
    
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100',
            'password' => 'required|min:5',
            'role_id' => 'required',
            'plan_id' => 'required',
            'en_condominios' => 'nullable',
            'en_inmuebles' => 'nullable',
            'perm_modulos' => 'nullable',
            'perm_acciones' => 'nullable',
        ]);
    
        if ($request->id) {
            $user = User::find($request->id);
        } else {
            $user = new User;
        }
    
        if (Auth::user()->hasRole('SuperAdmin') || Auth::user()->hasRole('Admin')) {
    
            $plan = Plan::find($request->plan_id);
    
            // Verificar si se encontró el plan
            if (!$plan) {
                return response()->json(['message' => 'El plan no existe'], 404);
            } else {
    
                $role = DB::table('roles')->where('id', $request->role_id)->first();
    
                if (!$role) {
                    return response()->json(['message' => 'El rol no existe'], 404);
                }
    
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->plan_id = $request->plan_id;
                $user->admin_id = $userId;
                $user->en_condominios = $request->en_condominios;
                $user->en_inmuebles = $request->en_inmuebles;
                $user->perm_modulos = $request->perm_modulos;
                $user->perm_acciones = $request->perm_acciones;
    
                
    
                $user->save();
    
                if (Auth::user()->hasRole('SuperAdmin')) {
                    // Asignar el id del nuevo usuario a admin_id después de guardar
                    $user->admin_id = $user->id;
                    $user->assignRole($role->name);

                } elseif (Auth::user()->hasRole('Admin')) {
                    $user->admin_id = $user->admin_id;
                    $user->assignRole($role->name);
                }
                
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
