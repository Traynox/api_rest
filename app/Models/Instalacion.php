<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalacion extends Model
{
    use HasFactory;

    protected $primaryKey ='id_instalacion';
    protected $table = 'instalaciones';
    public $timestamps = false;
    protected $fillable = [
        'direccion',
        'fecha_instalacion',
        'garantia',
        'factura_fisica',
        'id_cliente'
    ];


    public function motores()
    {
        return $this->belongsToMany(Motor::class, 'instalaciones_motores', 'id_instalacion', 'id_motor')
        ->withPivot('id_instalacion','id_motor','cantidad','precio');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class,'id_cliente');
    }

    public function scopeFilter($query,$buscar)
    {
        // $buscar=request('buscar');
        return $query->whereHas('motores',
        function($query) use ($buscar){
            if($buscar){
                return $query->where('marca','like','%'.$buscar.'%')
                ->orWhere('tipo_motor','like','%'.$buscar.'%')
                ->orWhere('modelo','like','%'.$buscar.'%');
            }
    })->orWhereHas('cliente',
    function($query) use ($buscar){
        if($buscar){
            return $query->where('nombre','like',"%$buscar%")
                 ->orWhere('apellido','like',"%$buscar%")
                 ->orWhere('telefono','like',"%$buscar%");
        }

    })->orWhere('fecha_instalacion','like','%'.$buscar.'%')
      ->orWhere('garantia','like','%'.$buscar.'%');
                   
      
    }


}
