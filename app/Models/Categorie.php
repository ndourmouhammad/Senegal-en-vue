<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Les relations entre les autres models
    public function evenements()
    {
        return $this->hasMany(Evenement::class);
    }
}
