<?php

namespace App\Models;


use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_users',
        
       
    ];

    public function user(): BelongsTo
    {
        return $this->belongTo(User::class);
    }
}
