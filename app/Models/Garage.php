<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Garage extends Model
{
    use HasFactory, SoftDeletes; 

    // Table associée au modèle
    protected $table = 'garages';

    // Champs pouvant être remplis par l'utilisateur
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'specializations',
    ];

    public function interventions() {
        return $this->hasMany(Intervention::class);
    }
    
    
}
