<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['libelle', 'description', 'contenu'];
    
    

    protected $table = 'activites'; // Nom de la table si différent

    // La méthode pour définir la relation many-to-many avec SiteTouristique
    public function sitesTouristiques()
    {
        return $this->belongsToMany(SiteTouristique::class, 'site_touristique_activite', 'activite_id', 'site_touristique_id');
    }
}
