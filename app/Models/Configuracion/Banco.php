<?php

namespace App\Models\Configuracion;

use App\Models\User;
use App\Models\Condominios\Condominio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banco extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'condominio_id',
        'fecha_registro',
        'banco',
        'cuenta',
        'saldo_inicial',
    ];

    // Relación: Un banco pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un banco pertenece a un solo condominio
    public function condominio(): BelongsTo
    {
        return $this->belongsTo(Condominio::class);
    }
}
