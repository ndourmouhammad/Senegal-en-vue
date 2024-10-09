<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Excursion extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site_touristique()
    {
        return $this->belongsTo(Region::class);
    }

    // La méthode pour définir la relation many-to-many avec Activite
    public function activities()
    {
        return $this->belongsToMany(Activite::class, 'excursion_activite', 'excursion_id', 'activite_id');
    }
    
}
