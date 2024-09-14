<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;

    protected $guarded = [];

     // Relation avec le touriste
     public function touriste()
     {
         return $this->belongsTo(User::class, 'touriste_id');
     }
 
     // Relation avec le guide
     public function guide()
     {
         return $this->belongsTo(User::class, 'guide_id');
     }
}
