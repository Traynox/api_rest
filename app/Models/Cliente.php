<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey ='id_cliente';
    protected $table = 'clientes';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
    ];
    public function instalaciones()
    {
        //$fecha=request('fecha');//obtiene el valor de cualquier valor que se mando del ultimo form mediante el nombre
       
        return $this->hasMany(Instalacion::class,'id_cliente');
    }

    
    public function scopeFilter($query,$buscar)
    {
        // $buscar=request('buscar');
        return $query->where('nombre','like','%'.$buscar.'%')
                    ->orWhere('apellido','like','%'.$buscar.'%')
                    ->orWhere('telefono','like','%'.$buscar.'%');
      
    }
}
