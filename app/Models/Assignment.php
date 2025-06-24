<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicule_id',
        'driver_id',
        'date_debut',
        'type_affectation',
        'remarques'
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
