<?php

namespace App\Http\Controllers\Administracion\Condominios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Condominios\Condominio;
use App\Models\Plan;
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
        $condominios = Condominio::where('user_id', $user->admin_id)->orderBy('id', 'desc')->get();

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
            'ci_admin' => 'required|max:13',
            'name_admin' => 'required|string|max:200',
            'telefono_admin' => 'required|max:10',
            'email_admin' => 'required',
            'obligado' => 'nullable',
            'ruc_contador' => 'nullable|max:13',
            'nombre_contador' => 'nullable|string|max:200',
            'firma_electronica' => 'nullable',
            'clave_firma' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            'reserva_legal_actual' => 'nullable',

        ]);



        if ($request->id) {
            $condominios = Condominio::find($request->id);
        } else {
            $condominios = new Condominio();
        }

        $var1 = Condominio::where('user_id', $user->admin_id)->count();
        $var2 = Plan::where('id', $user->plan_id)->first();


        if ($var1 >= $var2->lim_condominios) {

            return response()->json(['message' => 'Ha alcanzado el limite de su plan'], 401);
        } else {
            $condominios->user_id = $user->admin_id;
            $condominios->ruc_condominio = $request->ruc_condominio;
            $condominios->name_condominio = $request->name_condominio;
            $condominios->cod_condominio = $request->cod_condominio;
            $condominios->calle_principal = $request->calle_principal;
            $condominios->numeracion = $request->numeracion;
            $condominios->calle_secundaria = $request->calle_secundaria;
            $condominios->sector = $request->sector;
            $condominios->telefono = $request->telefono;
            $condominios->ciudad = $request->ciudad;
            $condominios->ci_admin = $request->ci_admin;
            $condominios->name_admin = $request->name_admin;
            $condominios->telefono_admin = $request->telefono_admin;
            $condominios->email_admin = $request->email_admin;
            $condominios->obligado = $request->obligado;
            $condominios->ruc_contador = $request->ruc_contador;
            $condominios->nombre_contador = $request->nombre_contador;
            $condominios->reserva_legal_actual = $request->reserva_legal_actual;
            if ($request->hasFile('firma_electronica')) {

                $firmaPath = $request->file('firma_electronica')->store('firmas', 'public');
                $condominios->firma_electronica = $firmaPath;
            }
            $condominios->clave_firma = $request->clave_firma;

            if ($request->hasFile('logo')) {

                $logoPath = $request->file('logo')->store('logos', 'public');
                $condominios->logo = $logoPath;
            }

            $condominios->save();

            return response()->json([
                'message' => 'El registro ha sido guardado correctamente',
                'condominios' => $condominios,
            ]);
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
