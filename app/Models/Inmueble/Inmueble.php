<?php

namespace App\Models\Inmueble;

use App\Models\Condominios\Condominio;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inmueble extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name_inmueble',
        'condominio_id',
        'plantas',
        'alicuotas',
        'expensas',
        'propietario_id',
        'residente_id',
        'fecha_entrega',
        'es_residente',

    ];

    // Relación: Un condominio pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un inmueble pertenece a un solo propietario
    public function propietario(): BelongsTo
    {
        return $this->belongsTo(Propietario::class);
    }

    // Relación: Un inmueble pertenece a un solo residente
    public function residente(): BelongsTo
    {
        return $this->belongsTo(Residente::class);
    }

    // Relación: Un inmueble pertenece a un solo condominio
    public function condominio(): BelongsTo
    {
        return $this->belongsTo(Condominio::class);
    }
}
