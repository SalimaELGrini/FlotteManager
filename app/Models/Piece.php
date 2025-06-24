<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    use HasFactory;

    // Si tu utilises des clés personnalisées
    protected $fillable = [
        'nom', 'reference', 'type', 'description'
    ];

    // Définir la relation avec la table 'neussite'
    public function neussites()
    {
        return $this->belongsToMany(Intervention::class, 'neussite')
                    ->withPivot('prix_piece', 'date_change', 'nom_technicien')
                    ->withTimestamps();
    }
}
