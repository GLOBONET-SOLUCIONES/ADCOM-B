<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Condominios\Condominio;
use App\Models\Configuracion\AdminFirma;
use App\Models\Configuracion\AreaComunale;
use App\Models\Configuracion\Empleado;
use App\Models\Configuracion\FirmaEmail;
use App\Models\Configuracion\PresidenteTesorero;
use App\Models\Configuracion\Proveedore;
use App\Models\Configuracion\ProveedorEmpleado;
use App\Models\Configuracion\Relacione;
use App\Models\Configuracion\Secuenciale;
use App\Models\Plan;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'confirmed_password',
        'role_id',
        'plan_id',
        'admin_id',
        'en_condominios',
        'en_inmuebles',
        'perm_modulos',
        'perm_acciones',
        'inactivo',
        'fecha_inactivo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación: Un administrador (usuario) puede tener muchos condominios
    public function condominios(): HasMany
    {
        return $this->hasMany(Condominio::class);
    }

    // Relación: Un usuario puede tener muchos planes
    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }

    // Relación: Un usuario puede tener muchas relaciones familiares
    public function relacionesFamiliares(): HasMany
    {
        return $this->hasMany(Relacione::class);
    }

    // Relación: Un usuario puede tener muchas secuencias
    public function secuencialesDocumentos(): HasMany
    {
        return $this->hasMany(Secuenciale::class);
    }

    // Relación: Un usuario puede tener muchas firmas
    public function firmaAdministradores(): HasMany
    {
        return $this->hasMany(AdminFirma::class);
    }

    // Relación: Un usuario puede tener muchas presidentes y tesoreros
    public function presiTesoreros(): HasMany
    {
        return $this->hasMany(PresidenteTesorero::class);
    }

    // Relación: Un usuario puede tener muchas areas comunales
    public function areasComunales(): HasMany
    {
        return $this->hasMany(AreaComunale::class);
    }

    // Relación: Un usuario puede tener muchas firmas_email
    public function firmaEmails(): HasMany
    {
        return $this->hasMany(FirmaEmail::class);
    }

    // Relación: Un usuario puede tener muchos proveedores
    public function proveedores(): HasMany
    {
        return $this->hasMany(Proveedore::class);
    }

    // Relación: Un usuario puede tener muchos empleados
    public function empleados(): HasMany
    {
        return $this->hasMany(Empleado::class);
    }
}
