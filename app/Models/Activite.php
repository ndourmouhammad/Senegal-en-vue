<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    use HasFactory;

    protected $fillable = ['libelle', 'description', 'contenu'];
    
    public function sites_touristiques()
    {
        return $this->belongsToMany(SiteTouristique::class);
    }
}
