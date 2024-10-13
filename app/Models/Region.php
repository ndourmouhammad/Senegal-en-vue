<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Les relations entre les autres models
    public function sites_touristiques()
    {
        return $this->hasMany(SiteTouristique::class);
    }
}
