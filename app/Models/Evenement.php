<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Les relations entre les autres models
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function siteTouristique()
    {
        return $this->belongsTo(SiteTouristique::class, 'site_touristique_id');
    }

}
