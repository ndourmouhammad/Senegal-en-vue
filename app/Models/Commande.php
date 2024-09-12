<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Les relations entre les autres models
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site_touristique()
    {
        return $this->belongsTo(SiteTouristique::class);
    }
}
