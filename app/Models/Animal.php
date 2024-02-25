<?php

namespace App\Models;
use App\Models\Eleveur;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'Nom',
        'race',
        'poids',
        'NomAliments',
        'quantite',
        'image',
        'sexe',
        'age',
        'prix',
        'Description',
        'user_id'
    ];
    
    public function eleveurs(): BelongsToMany
    {
        return $this->belongsToMany(Eleveur::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id'
    );
    }
    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class);
    }
}
