<?php

namespace App\Models\Condominios;

use App\Models\User;
use App\Models\Inmueble\Inmueble;
use App\Models\Configuracion\Empleado;
use App\Models\Configuracion\Relacione;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion\AdminFirma;
use App\Models\Configuracion\FirmaEmail;
use App\Models\Configuracion\Proveedore;
use App\Models\Configuracion\Secuenciale;
use App\Models\Configuracion\AreaComunale;
use App\Models\Configuracion\PresidenteTesorero;
use App\Models\Facturacion\FacturacionSecuencia;
use App\Models\Plancuentas\PlanCuenta;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Condominio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ruc_condominio',
        'name_condominio',
        'cod_condominio',
        'calle_principal',
        'numeracion',
        'calle_secundaria',
        'sector',
        'telefono',
        'ciudad',
        'ci_admin',
        'name_admin',
        'telefono_admin',
        'email_admin',
        'obligado',
        'ruc_contador',
        'nombre_contador',
        'firma_electronica',
        'clave_firma',
        'logo',

    ];

    // Relación: Un condominio pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un inmueble tiene muchos condominios
    public function condominios(): HasMany
    {
        return $this->hasMany(Inmueble::class);
    }


    // Relación: Un condominio tiene muchos planes de cuenta
    public function plancuentas(): HasMany
    {
        return $this->hasMany(PlanCuenta::class);
    }

    // // Relación: Un condominio puede tener muchas relaciones familiares
    // public function relacionesFamiliares(): HasMany
    // {
    //     return $this->hasMany(Relacione::class);
    // }

    // Relación: Un condominio puede tener muchas secuencias
    public function secuencialesDocumentos(): HasMany
    {
        return $this->hasMany(Secuenciale::class);
    }

    // Relación: Un condominio puede tener muchas firmas
    public function firmaAdministradores(): HasMany
    {
        return $this->hasMany(AdminFirma::class);
    }

    // Relación: Un condominio puede tener muchas presidentes y tesoreros
    public function presiTesoreros(): HasMany
    {
        return $this->hasMany(PresidenteTesorero::class);
    }

    // Relación: Un condominio puede tener muchas areas comunales
    public function areasComunales(): HasMany
    {
        return $this->hasMany(AreaComunale::class);
    }

    // Relación: Un condominio puede tener muchas firmas_email
    public function firmaEmails(): HasMany
    {
        return $this->hasMany(FirmaEmail::class);
    }

    // Relación: Un condominio puede tener muchos proveedores
    public function proveedores(): HasMany
    {
        return $this->hasMany(Proveedore::class);
    }

    // Relación: Un condominio puede tener muchos empleados
    public function empleados(): HasMany
    {
        return $this->hasMany(Empleado::class);
    }

    // Relación: Un condominio puede tener muchas secuencias en facturacion
    public function facturacionSecuencias(): HasMany
    {
        return $this->hasMany(FacturacionSecuencia::class);
    }
}
