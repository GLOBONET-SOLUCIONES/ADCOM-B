<?php

namespace App\Models\Inmueble;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Residente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recibo',
        'name_residente',
        'ci_residente',
        'relacion_residente',
        'nacimiento_residente',
        'telefono_residente',
        'celular_residente',
        'email_residente',
        'envio_emailprincipal',
        'email_secundarioresidente',
        'envio_emailsecundario',

    ];

    // Relación: Un condominio pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un residente tiene muchos inmuebles
    public function inmuebles(): HasMany
    {
        return $this->hasMany(Inmueble::class);
    }
}
