<?php

namespace App\Http\Controllers\Administracion\Condominios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Condominios\Condominio;
use App\Models\User;
use PharIo\Manifest\Author;

class CondominioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Lamada a los condominios en orden
        $condominios = Condominio::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        return response()->json([
            'condominios' => $condominios
        ]);
    }



    public function store(Request $request)
    {
        $user = auth()->user();


        $this->validate($request, [
            'ruc_condominio' => 'required|max:13',
            'name_condominio' => 'required|string|max:200',
            'cod_condominio' => 'required',
            'calle_principal' => 'required',
            'numeracion' => 'required',
            'calle_secundaria' => 'nullable',
            'sector' => 'nullable',
            'telefono' => 'required|max:10',
            'ciudad' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',

        ]);



        if ($request->id) {
            $condominios = Condominio::find($request->id);
        } else {
            $condominios = new Condominio();

            if ($user->lim_condominios === 0) {
                return response()->json(['message' => 'Has alacanzado el límite asignado'], 401);
            } else {
                $limCondominios = $user->lim_condominios - 1;
            }
        }


        if ($user->hasRole('Admin')) {

            $condominios->ruc_condominio = $request->ruc_condominio;
            $condominios->name_condominio = $request->name_condominio;
            $condominios->cod_condominio = $request->cod_condominio;
            $condominios->calle_principal = $request->calle_principal;
            $condominios->numeracion = $request->numeracion;
            $condominios->calle_secundaria = $request->calle_secundaria;
            $condominios->sector = $request->sector;
            $condominios->telefono = $request->telefono;
            $condominios->ciudad = $request->ciudad;
            $condominios->user_id = $user->id;

            if ($request->hasFile('logo')) {

                $logoPath = $request->file('logo')->store('logos', 'public');
                $condominios->logo = $logoPath;
            }

            $admin = User::find($user->id);

            $admin->ci_ruc = $user->ci_ruc;
            $admin->name = $user->name;
            $admin->telefono = $user->telefono;
            $admin->email = $user->email;
            $admin->obligado = $user->obligado;
            $admin->ruc_contador = $user->ruc_contador;
            $admin->nombre_contador = $user->nombre_contador;
            $admin->lim_condominios = $limCondominios;
            $admin->lim_subusuarios = $user->lim_subusuarios;
            $admin->plan = $user->plan;
            $admin->plan_act = $user->plan_act;
            $admin->plan_ant = $user->plan_ant;
            $admin->fecha_inicio = $user->fecha_inicio;
            $admin->fecha_final = $user->fecha_final;
            $admin->password = $user->password;

            $admin->save();
            $condominios->save();

            return response()->json([
                'message' => 'El registro ha sido guardado correctamente',
                'condominios' => $condominios,
                'admin' => $admin,
            ]);
        } else {
            return response()->json(['message' => 'No tiene los permisos necesarios'], 401);
        }
    }

    public function show(string $id)
    {
        $condominios = Condominio::find($id);

        return response()->json([
            'condominios' => $condominios
        ]);
    }



    public function destroy(string $id)
    {
        $condominios = Condominio::find($id);
        $condominios->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'condominios' => $condominios
        ]);
    }
}
