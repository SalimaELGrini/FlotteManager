<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panne extends Model
{
    use HasFactory;

    protected $table = 'pannes';

    protected $fillable = [
        'vehicule_id',
        'description',
        'date_panne',
        'resolved',
        'driver_id',
        'status',
    ];

    protected $casts = [
        'resolved' => 'boolean',
        'date_panne' => 'date',
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

        public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }


    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
    


    public function scopeUnresolved($query)
    {
        return $query->where('resolved', false);
    }

}
