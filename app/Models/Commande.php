<?php

namespace App\Models;
use App\Models\Paiement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $fillable = [
        'reference',
        'total',
        'id_clients',
        'status',
        'adresse-de-livraison',
        'accepte'

    ];
    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class);
    }
    

    public function animals()
    {
        return $this->hasMany(CommandeProduit::class, 'commande_id')->with('animal');
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class,'id_clients'
    );
}
}