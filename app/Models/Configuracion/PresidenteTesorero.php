<?php

namespace App\Models\Configuracion;

use App\Models\User;
use App\Models\Condominios\Condominio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PresidenteTesorero extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'condominio_id',
        'name_presidente',
        'name_tesorero',
    ];

    // Relación: Un presidente y tesorero pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un presidente y tesorero pertenece a un solo condominio
    public function condominio(): BelongsTo
    {
        return $this->belongsTo(Condominio::class);
    }
}
