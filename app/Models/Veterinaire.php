<?php

namespace App\Models;
use App\Models\Eleveur;
use App\Models\User;
use App\Models\Recommandation;
use App\Models\RendezVous;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Veterinaire extends Model
{
    use HasFactory;
    use Notifiable;
    
    protected $fillable = [
        'id_users',
        'Nomcabinet',
        'specialite',
    ];
    public function eleveurs(): BelongsToMany
    {
        return $this->belongsToMany(Eleveurs::class);
    }
    public function recommandations(): HasMany
    {
        return $this->hasMany(Recommandation::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users');
    }
    public function rendezVous(): BelongsToMany
    {
        return $this->belongsToMany(RendezVous::class, 'rendez_vouses', 'id_veterinaire', 'id');
    }
       

}
