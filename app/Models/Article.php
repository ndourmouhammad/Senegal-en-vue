<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Les relations entre les autres models
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }


    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'article_user_like')->withPivot('is_like')->withTimestamps();
    }


}
