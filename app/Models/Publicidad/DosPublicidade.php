<?php

namespace App\Models\Publicidad;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DosPublicidade extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'publicidad_1',
        'publicidad_2',
        'publicidad_3',
        'publicidad_4',
        'publicidad_5',
        'tiempo_publicidad',

    ];

    // Relación: Una publicidad pertenece a un solo administrador (usuario)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
