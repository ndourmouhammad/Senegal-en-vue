<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Les relations entre les autres models
    public function sites_touristiques()
    {
        return $this->hasMany(Activite::class);
    }
}
