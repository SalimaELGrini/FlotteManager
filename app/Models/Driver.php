<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Driver extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'nom',
        'telephone',
        'numero_permis',
        'type_permis',
        'date_expiration_permis',
        'adresse',
        'date_embauche',
        'contact_urgence',
        'status',
         
    ];
        
    public function vehicules()
    {
        return $this->belongsToMany(Vehicule::class, 'assignments')
                    ->withPivot('date_debut', 'date_fin', 'type_affectation', 'remarques');
    }
    public function pannes() {
        return $this->hasMany(Panne::class);
    }
        

}
