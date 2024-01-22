<?php

namespace App\Models\Condominios;

use App\Models\User;
use App\Models\Configuracion\Relacione;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion\AdminFirma;
use App\Models\Configuracion\FirmaEmail;
use App\Models\Configuracion\Secuenciale;
use App\Models\Configuracion\AreaComunale;
use App\Models\Configuracion\PresidenteTesorero;
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
        'logo',

    ];

    // Relación: Un condominio pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
