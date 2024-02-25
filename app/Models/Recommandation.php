<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommandation extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'id_veterinaire',
        'description',
        'image',
        'dateEnvoie',
        'Titre',
        'conseils'
    ];

    public function veterinaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_veterinaire');
    }
}
