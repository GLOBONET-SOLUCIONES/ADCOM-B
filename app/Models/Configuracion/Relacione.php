<?php

namespace App\Models\Configuracion;

use App\Models\Condominios\Condominio;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Relacione extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'relacion',
    ];

    // Relación: Una relacion familiar pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Una relacion familiar pertenece a un solo condominio
    public function condominio(): BelongsTo
    {
        return $this->belongsTo(Condominio::class);
    }
}
