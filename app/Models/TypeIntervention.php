<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeIntervention extends Model
{
    use HasFactory;

    protected $table = 'type_interventions'; // 

    protected $fillable = [
        'name',
        'description'
    ];

    public static function booted()
    {
        static::saving(function ($typeIntervention) {
            $typeIntervention->name = ucfirst(strtolower($typeIntervention->name));
        });
    }

}
