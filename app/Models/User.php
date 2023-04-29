<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $hidden = ["mdp"];

    protected $fillable = ["nom", "prenom", "login", "mdp"];

    protected $attributes = ["type" => null];

    public function getAuthPassword() {
        return $this->mdp;
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
    
    public function cours() {
        return $this->hasMany(Cours::class, "user_id");
    }

    public function courss()
    {
        return $this->belongsToMany(Cours::class, 'cours_users', 'user_id', 'cours_id');
    }

}
