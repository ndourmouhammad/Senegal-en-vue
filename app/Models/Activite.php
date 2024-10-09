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
    public function excursions()
    {
        return $this->belongsToMany(Excursion::class, 'excursion_activite', 'activite_id', 'excursion_id');
    }
}
