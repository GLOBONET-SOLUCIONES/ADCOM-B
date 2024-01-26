<?php

namespace App\Models\Configuracion;

use App\Models\User;
use App\Models\Condominios\Condominio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'condominio_id',
        'ci_ruc',
        'razon_social',
        'calle_principal',
        'numero',
        'calle_secundaria',
        'telefono',
        'celular',
        'email',
        'fecha_ingreso',
        'fecha_inactivo',
        'name_contacto',
        'telefono_contacto',
        'inactivo',
        'motivo',
    ];

    // Relación: Un proveedor pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un proveedor pertenece a un solo condominio
    public function condominio(): BelongsTo
    {
        return $this->belongsTo(Condominio::class);
    }
}
