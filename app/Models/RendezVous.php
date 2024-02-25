<?php

namespace App\Models;

use App\Models\Eleveur;
use App\Models\User;
use App\Models\Veterinaire;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
class RendezVous extends Model
{
    use HasFactory;
    // use Notifiable;
    protected $fillable = [
        'id_eleveur',
        'id_veterinaire',
        'dateRendezVous',
        'Motif',
        'heure',
        'status' 
        
       
    ];

    

    public function veterinaires()
    {
        return $this->belongsToMany(Veterinaire::class, 'rendez_vouses', 'id', 'id_veterinaire');
    }
    
    public function eleveurs()
    {
        return $this->belongsToMany(User::class, 'rendez_vouses', 'id', 'id_eleveur');
    }
    
}
