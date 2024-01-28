<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;
use App\Models\Configuracion\FirmaEmail;

class FirmaEmailController extends Controller
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
        
        $firmaEmail = FirmaEmail::where('condominio_id', $propiedad->id)
            ->where('user_id', $user->admin_id)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'firmaEmail' => $firmaEmail
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
            'name' => 'required',
            'cargo' => 'required',
            'telefono' => 'required',
            'name_empresa' => 'required',
            'ciudad_pais' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);


        if ($request->id) {
            $firmaEmail = FirmaEmail::find($request->id);
        } else {

            $existFirmaEmail = FirmaEmail::where('condominio_id', $request->condominio_id)->first();

            if ($existFirmaEmail && !$request->id) {
                return response()->json(['message' => 'Ya existe una firma e-mail registrada en la propiedad ' . $propiedad->name_condominio . ', edite la información.'], 403);
            }

            $firmaEmail = new FirmaEmail();
        }

        $firmaEmail->user_id = $user->admin_id;
        $firmaEmail->condominio_id = $request->condominio_id;
        $firmaEmail->name = $request->name;
        $firmaEmail->cargo = $request->cargo;
        $firmaEmail->telefono = $request->telefono;
        $firmaEmail->name_empresa = $request->name_empresa;
        $firmaEmail->ciudad_pais = $request->ciudad_pais;

        if ($request->hasFile('logo')) {

            $logoPath = $request->file('logo')->store('firmas_email', 'public');
            $firmaEmail->logo = $logoPath;
        }

        $firmaEmail->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'firmaEmail' => $firmaEmail,
        ]);
    }

    public function show(string $id)
    {
        $firmaEmail = FirmaEmail::find($id);

        return response()->json([
            'firmaEmail' => $firmaEmail
        ]);
    }

    public function destroy(string $id)
    {
        $firmaEmail = FirmaEmail::find($id);
        $firmaEmail->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'firmaEmail' => $firmaEmail
        ]);
    }
}
