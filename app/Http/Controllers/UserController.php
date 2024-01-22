<?php

namespace App\Http\Controllers;

use App\Models\Configuracion\Relacione;
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
        $user = auth()->user();

        // Lamada a los usuarios en orden
        $users = User::where('admin_id', $user->admin_id)->orderBy('id','desc')->get();

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
        $userAuth = auth()->user();
    
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100',
            'password' => 'required|min:5',
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

            $user->plan_id = $request->plan_id;
        }
        
        if ($userAuth->role_id === 1) {

            $plan = Plan::find($request->plan_id);
    
            // Verificar si se encontró el plan
            if (!$plan) {
                return response()->json(['message' => 'El plan no existe'], 404);
            } else {
    
                $role = DB::table('roles')->where('id', 2)->first();

                if (!$role) {
                    return response()->json(['message' => 'El rol no existe'], 404);
                }
    
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->en_condominios = null;
                $user->en_inmuebles = null;
                $user->perm_modulos = null;
                $user->perm_acciones = null;
                $user->admin_id = $userAuth->id;
                $user->role_id = $role->id;
    
                
                $user->save();


                $user->admin_id = $user->id;
                $user->assignRole('Admin');


                $relacionExist = Relacione::where('user_id', $user->admin_id)->first();

                if (!$relacionExist) {

                    $relaciones = [
                        "PROPIETARIO",
                        "CONYUGE",
                        "HIJO",
                        "HERMANO",
                        "NIETO",
                        "SUEGRO",
                        "ARRENDATARIO",
                        "TIA",
                    ];

                    foreach ($relaciones as $relacion) {
                        $relFamiliar = new Relacione;
                        $relFamiliar->relacion = $relacion;
                        $relFamiliar->user_id = $user->admin_id;
                        $relFamiliar->save();
                    }
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




    // SUBUSUARIOS
    public function indexSubUser()
    {
        $user = auth()->user();

        $subusers = User::where('admin_id', $user->admin_id)->where('plan_id', $user->plan_id)->orderBy('id','desc')->get();

        return response()->json([
            'subusers' => $subusers
        ]);
    }

    public function storeSubUser(Request $request)
    {
        $userAuth = auth()->user();
    
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:100',
            'password' => 'required|min:5',
            'en_condominios' => 'nullable|string',
            'en_inmuebles' => 'nullable|string',
            'perm_modulos' => 'nullable|string',
            'perm_acciones' => 'nullable|string',
        ]);
    
        if ($request->id) {
            $subuser = User::find($request->id);
        } else {
            $subuser = new User;

            $subuser->plan_id = $userAuth->plan_id;
        }

        if ($userAuth->role_id === 1) {

            $subuser->admin_id = $userAuth->admin_id;
        } elseif ($userAuth->role_id === 2) {

            $subuser->admin_id = $userAuth->id;
        }

        $role = DB::table('roles')->where('id', 3)->first();


        if (!$role) {
            return response()->json(['message' => 'El rol no existe'], 404);
        }

        $subuser->name = $request->name;
        $subuser->email = $request->email;
        $subuser->password = Hash::make($request->password);
        $subuser->role_id = $role->id;

        // Convertir los campos de selección a formato JSON
        $subuser->en_condominios = json_encode($request->en_condominios);
        $subuser->en_inmuebles = json_encode($request->en_inmuebles);
        $subuser->perm_modulos = json_encode($request->perm_modulos);
        $subuser->perm_acciones = json_encode($request->perm_acciones);
        $subuser->assignRole('Subusuario');

        $subuser->save();


        return response()->json([
            'message' => 'El usuario ha sido guardado exitosamente',
            'subuser' => $subuser,
        ]);
    }

    public function showSubUser(string $id)
    {
        $subuser = User::find($id);

        return response()->json([
            'subuser' => $subuser
        ]);
    }



    public function destroySubUser(string $id)
    {
        $subuser = User::find($id);
        $subuser->delete();


        return response()->json([
            'message' => 'El usuario ha sido eliminado correctamente',
            'subuser' => $subuser
        ]);
    }
}
