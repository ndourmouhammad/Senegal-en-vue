<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteTouristique extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Les relations entre les autres models
    protected $table = 'site_touristiques'; // Nom de la table si différent

    // La méthode pour définir la relation many-to-many avec Activite
    public function activities()
    {
        return $this->belongsToMany(Activite::class, 'site_touristique_activite', 'site_touristique_id', 'activite_id');
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
