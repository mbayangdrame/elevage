<?php

namespace App\Models;

use App\Models\Commande;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_commandes',
        'typePaiements'
    ];

    public function commandes(): HasOne
    {
        return $this->hasOne(Commande::class);
    }
}
