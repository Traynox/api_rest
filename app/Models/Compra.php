<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $primaryKey ='id_compra';
    protected $table = 'compras';
    public $timestamps = false;
    
    protected $fillable = [
        'fecha',
        'id_proveedor',
        'factura_fisica'
    ];

    public function proveedor()
    {
       
        //return $this->hasMany(Proveedor::class,'id_proveedor');
        return $this->belongsTo(Proveedor::class,'id_proveedor');
       
    }

    public function motores()
    {
        return $this->belongsToMany(Motor::class,'motores_compra','id_compra','id_motor')
        ->withPivot('id_motor','id_compra','cantidad','precio');
    }

    public function scopeFilter($query,$buscar)
    {
        // $buscar=request('buscar');
        return $query->whereHas('proveedor',
        function($query) use ($buscar){
            if($buscar){
                return $query->where('nombre','like',"%$buscar%")
                     ->orWhere('telefono','like',"%$buscar%");
            }
    })->orWhereHas('motores',
    function($query) use ($buscar){
        if($buscar){
            return $query->where('marca','like',"%$buscar%")
                 ->orWhere('tipo_motor','like',"%$buscar%")
                 ->orWhere('modelo','like',"%$buscar%");
        }

    })->orWhere('fecha','like',"%$buscar%")->
        orWhere('factura_fisica','like',"%$buscar%");
                   
      
    }


}
