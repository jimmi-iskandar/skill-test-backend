<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CltLayer extends Model
{
    // Pastikan ini mengarah ke tabel 'layers'
    protected $table = 'layers'; 

    protected $fillable = [
        'layup_id', 
        'layer_order', 
        'thickness', 
        'width', 
        'angle'
    ];

    // Relasi balik ke Layup
    public function layup()
    {
        return $this->belongsTo(CltLayup::class, 'layup_id');
    }
}