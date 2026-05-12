<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CltLayer extends Model
{
    protected $table = 'clt_layers'; 

    protected $fillable = ['layup_id', 'layer_order', 'thickness', 'width', 'angle'];
}