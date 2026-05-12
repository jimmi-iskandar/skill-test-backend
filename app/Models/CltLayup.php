<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CltLayup extends Model
{
    protected $table = 'layups'; 

    
    protected $fillable =[
        'supplier_id',
        'name'
    ];
    // Relasi ke Atas: Layup ini punya siapa? (Bapaknya)
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function layers()
    {
        return $this->hasMany(CltLayer::class, 'layup_id');
    }
}
