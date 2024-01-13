<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'licencia',
        'lim_condominios',
        'lim_subusuarios',
        'precio',
    ];

    // Relación: Un plan pertenece a un solo usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
