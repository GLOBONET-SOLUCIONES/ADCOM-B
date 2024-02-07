<?php

namespace App\Models\Finanzas\Inventario;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'codigo',
        'name',
        'marca',
        'unidad_medida',
        'stock',
        'tiempo_publicidad',

    ];

    // Relación: Una publicidad pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
