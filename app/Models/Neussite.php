<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Neussite extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'neussite';

    protected $fillable = [
        'intervention_id',
        'piece_id',
        'date_change',
        'status',
        'prix_piece',
        'nom_technicien'
    ];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }

    public function piece()
    {
        return $this->belongsTo(Piece::class);
    }
}
