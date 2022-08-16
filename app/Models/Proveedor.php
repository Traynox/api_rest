<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_proveedor';
    protected $table = 'proveedores';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'telefono',
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class,'id_proveedor');
    }


    public function scopeFilter($query,$buscar)
    {
        // $buscar=request('buscar');
        return $query->where('nombre','like','%'.$buscar.'%')
                    ->orWhere('telefono','like','%'.$buscar.'%');
      
    }

}
