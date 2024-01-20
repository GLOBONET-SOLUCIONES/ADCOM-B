<?php

namespace App\Models\Inmueble;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Propietario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recibo',
        'name_propietario',
        'ci_propietario',
        'relacion_propietario',
        'nacimiento_propietario',
        'telefono_propietario',
        'celular_propietario',
        'email_propietario',
        'envio_emailprincipal',
        'email_secundariopropietario',
        'envio_emailsecundario',

    ];

    // Relación: Un condominio pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un propietario tiene muchos inmuebles
    public function inmuebles(): HasMany
    {
        return $this->hasMany(Inmueble::class);
    }
}
