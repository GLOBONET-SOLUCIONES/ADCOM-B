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
            'user_id' => 'required',
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

            'ci_ruc' => 'required|min:10|max:13',
            'name' => 'required',
            'telefono' => 'required',
            'email' => 'required|email',
            'obligado' => 'required',
            'ruc_contador' => 'nullable|max:13',
            'nombre_contador' => 'nullable|string',
        ]);



        if ($request->id) {
            $condominios = Condominio::find($request->id);
            $admin = User::find($user->id);
        } else {
            $condominios = new Condominio();
            $admin = new User();
        }

        if ($user->hasRole('SuperAdmin') || $user->hasRole('Admin')) {

            $condominios->ruc_condominio = $request->ruc_condominio;
            $condominios->name_condominio = $request->name_condominio;
            $condominios->cod_condominio = $request->cod_condominio;
            $condominios->calle_principal = $request->calle_principal;
            $condominios->numeracion = $request->numeracion;
            $condominios->sector = $request->sector;
            $condominios->telefono = $request->telefono;
            $condominios->ciudad = $request->ciudad;
            $condominios->user_id = $request->user_id;

            if ($request->hasFile('logo')) {

                $logoPath = $request->file('logo')->store('logos', 'public');
                $condominios->logo = $logoPath;
            }

            $admin->ci_ruc = $request->ci_ruc;
            $admin->name = $request->name;
            $admin->telefono = $request->telefono;
            $admin->email = $request->email;
            $admin->obligado = $request->obligado;
            $admin->ruc_contador = $request->ruc_contador;
            $admin->nombre_contador = $request->nombre_contador;


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
