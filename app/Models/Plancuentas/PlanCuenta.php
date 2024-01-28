<?php

namespace App\Models\Plancuentas;

use App\Models\Condominios\Condominio;
use App\Models\User;
use App\Models\Inmueble\Inmueble;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanCuenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'condominio_id',
        'codigo',
        'nombre_cuenta',
        'grupo_contable',
        'cuenta_superior',
        'suoerior_id',
        'saldo_actual',
    ];

    // Relación: Un Plan de cuentas pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un Plan de cuentas pertenece a uncondominio
    public function condominio(): BelongsTo
    {
        return $this->belongsTo(Condominio::class);
    }
}
