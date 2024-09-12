<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteTouristique extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Les relations entre les autres models
    public function activites()
    {
        return $this->belongsToMany(Activite::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
