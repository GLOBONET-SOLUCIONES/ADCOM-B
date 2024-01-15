<?php

namespace App\Models\Condominios;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
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
}
