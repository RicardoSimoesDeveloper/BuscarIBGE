<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'estado',
        'nome',
        'ibge'
    ];

    protected $with = ['estado'];

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado');
    }
}
