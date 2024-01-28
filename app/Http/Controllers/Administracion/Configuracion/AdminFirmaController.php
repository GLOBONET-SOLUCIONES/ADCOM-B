<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Condominios\Condominio;
use App\Models\Configuracion\AdminFirma;

class AdminFirmaController extends Controller
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
        
        $firmaAdmin = AdminFirma::where('condominio_id', $propiedad->id)
            ->where('user_id', $user->admin_id)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'firmaAdmin' => $firmaAdmin
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
            'firma_administrador' => 'nullable|image|mimes:jpeg,png,jpg',
            'condominio_id' => 'required',
        ]);


        if ($request->id) {
            $firmaAdmin = AdminFirma::find($request->id);
        } else {
            $existFirmaAdmin = AdminFirma::where('condominio_id', $request->condominio_id)->first();

            if ($existFirmaAdmin && !$request->id) {
                return response()->json(['message' => 'Ya existe una firma para este administrador en la propiedad ' . $propiedad->name_condominio . ', edite la información.'], 403);
            }

            $firmaAdmin = new AdminFirma();
        }

        $firmaAdmin->user_id = $user->admin_id;
        $firmaAdmin->condominio_id = $request->condominio_id;

        if ($request->hasFile('firma_administrador')) {

            $logoPath = $request->file('firma_administrador')->store('firmas_admin', 'public');
            $firmaAdmin->firma_administrador = $logoPath;
        }

        $firmaAdmin->save();

        return response()->json([
            'message' => 'El registro ha sido guardado correctamente',
            'firmaAdmin' => $firmaAdmin,
        ]);
    }

    public function show(string $id)
    {
        $firmaAdmin = AdminFirma::find($id);

        return response()->json([
            'firmaAdmin' => $firmaAdmin
        ]);
    }

    public function destroy(string $id)
    {
        $firmaAdmin = AdminFirma::find($id);
        $firmaAdmin->delete();


        return response()->json([
            'message' => 'El registro ha sido eliminado correctamente',
            'firmaAdmin' => $firmaAdmin
        ]);
    }
}
