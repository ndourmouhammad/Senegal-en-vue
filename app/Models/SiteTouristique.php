<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteTouristique extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Les relations entre les autres models
    protected $table = 'site_touristiques'; // Nom de la table si différent

    

    public function region()
    {
        return $this->belongsTo(Region::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function evenements()
    {
        return $this->hasMany(Evenement::class, 'site_touristique_id');
    }

    public function excursions()
    {
        return $this->hasMany(Excursion::class);
    }
}
