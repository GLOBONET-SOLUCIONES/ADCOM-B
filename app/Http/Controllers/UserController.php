<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
        if($request->id){
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:60',
                'password' => 'required|min:5',
                'role_id' => 'required',
            ]);
            $user = User::find($request->id);
        }else{
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:60|unique:users',
                'password' => 'required|min:5',
                'role_id' => 'required',
            ]);
            $user = new User;
        }

        if (Auth::user()->hasRole('SuperAdmin')) {
            $role = DB::table('roles')->where('id', $request->role_id)->first();
                if (!$role) {
                    return response()->json(['message' => 'El role no existe'], 404);
                }

                $user->fill([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ])->assignRole($role->name);
                $user->save();

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
