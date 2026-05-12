<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CltLayup extends Model
{
    protected $table = 'clt_layups'; 

    public function layers()
    {
        return $this->hasMany(CltLayer::class, 'layup_id');
    }
}
