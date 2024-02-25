<?php

namespace App\Models;
use App\Models\Veterinaire;
use App\Models\Animal;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleveur extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_eleveurs',
        
        
       
    ];
    public function veterinaires(): BelongsToMany
    {
        return $this->belongsToMany(Veterinaire::class);
    }
    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongTo(User::class);
    }
    public function rendezVous(): BelongsToMany
{
    return $this->belongsToMany(RendezVous::class, 'rendez_vouses', 'id_eleveur', 'id');
}
   
}
