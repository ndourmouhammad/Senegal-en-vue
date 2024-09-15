<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\Guard;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Les relations entre les autres models
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function sitesTouristiques()
    {
        return $this->hasMany(SiteTouristique::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
 
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getPhotoUrlAttribute()
{
    return $this->photo_profil ? asset('storage/photos/' . str_replace('public/', '', $this->photo_profil)) : null;
}

public function getCarteUrlAttribute()
{
    return $this->carte_guide ? asset('storage/cartes/' . str_replace('public/', '', $this->carte_guide)) : null;
}

// Les abonnements en tant que touriste (abonnements créés par ce user)
public function subscriptionsAsTourist()
{
    return $this->hasMany(Abonnement::class, 'touriste_id');
}

// Les abonnements en tant que guide (abonnements reçus par ce user)
public function subscriptionsAsGuide()
{
    return $this->hasMany(Abonnement::class, 'guide_id');
}

public function likedArticles()
    {
        return $this->belongsToMany(Article::class, 'article_user_like')->withPivot('is_like')->withTimestamps();
    }


    public function updateAverageRating($newRating)
    {
        // On s'assure que cet utilisateur existe bien dans la base
        if (!$this->exists) {
            throw new \Exception('L\'utilisateur n\'existe pas dans la base.');
        }
    
        // On récupère le nombre total de notes actuelles
        $totalRatings = $this->ratings_count ?? 0;
    
        // Calculer la somme des anciennes notes
        $oldTotalRating = $this->note * $totalRatings;
    
        // Incrémenter le nombre de notes
        $newTotalRatings = $totalRatings + 1;
    
        // Calculer la nouvelle moyenne
        $newAverageRating = ($oldTotalRating + $newRating) / $newTotalRatings;
    
        // Mettre à jour la note moyenne et le nombre total de notes
        $this->note = $newAverageRating;
        $this->ratings_count = $newTotalRatings;
    
        // Sauvegarder les modifications
        $this->save();
    }
    


}
