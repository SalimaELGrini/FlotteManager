<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    // Champs pouvant être remplis par l'utilisateur
    protected $fillable = [
        'vehicule_id',
        'type_intervention_id',
        'panne_id',
        'garage_id',
        'description',
        'date_intervention',
        'duration',
        'parts_used',
        'total_cost',
        'nom_technician'
    ];

    /**
     * Relation avec le modèle Garage (Chaque intervention a un seul garage)
     */
   
     public function garage()
     {
         return $this->belongsTo(Garage::class);
     }
     
     
     

    /**
     * Relation avec le modèle Vehicule (Chaque intervention concerne un seul véhicule)
     */
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    /**
     * Relation avec le modèle TypeIntervention
     */
    public function typeIntervention()
    {
        return $this->belongsTo(TypeIntervention::class, 'type_intervention_id');
    }

    /**
     * Relation avec le modèle Panne
     */
    public function panne()
    {
        return $this->belongsTo(Panne::class, 'panne_id');
    }

    /**
     * Relation avec la table Neussite (qui stocke les pièces utilisées dans l'intervention)
     */
    public function neussites()
    {
        return $this->hasMany(Neussite::class);
    }

    /**
     * Relation indirecte avec les pièces à travers la table Neussite
     */
    public function pieces()
    {
        return $this->hasManyThrough(Piece::class, Neussite::class, 'intervention_id', 'id', 'id', 'piece_id');
    }
}

