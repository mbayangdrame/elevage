<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commandeproduit extends Model
{
    use HasFactory;
    protected $fillable = [
        'commande_id',
        'id_animal',
        'quantite',
        'prix'
        

    ];
    public function animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

}
