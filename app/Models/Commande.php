<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commande extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Les relations entre les autres models
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function excursion()
    {
        return $this->belongsTo(Excursion::class, 'id_excursion');
    }
}
