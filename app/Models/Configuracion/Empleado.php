<?php

namespace App\Models\Configuracion;

use App\Models\User;
use App\Models\Condominios\Condominio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'condominio_id',
        'ci_ruc',
        'apellido',
        'name',
        'calle_principal',
        'numero',
        'calle_secundaria',
        'telefono',
        'celular',
        'email',
        'fecha_ingreso',
        'fecha_inactivo',
        'inactivo',
        'motivo',
    ];

    // Relación: Un empleado pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un empleado pertenece a un solo condominio
    public function condominio(): BelongsTo
    {
        return $this->belongsTo(Condominio::class);
    }
}
