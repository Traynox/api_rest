<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $primaryKey ='id_motor';
    protected $table = 'motores';
    public $timestamps = false;

    protected $fillable = [
        'marca',
        'tipo_motor',
        'modelo'
    ];

    public function compras()
    {
        return $this->
        belongsToMany(Compra::class,'motores_compra','id_motor','id_compra')
        ->withPivot('id_motor','id_compra','cantidad','precio');
    }

    public function instalaciones()
    {
        return $this->
        belongsToMany(instalacion::class, 'instalaciones_motores', 'id_motor','id_instalacion')
        ->withPivot('id_instalacion','id_motor','cantidad','precio');
    }

    public function scopeFilter($query,$buscar)
    {
        // $buscar=request('buscar');
        return $query->where('marca','like','%'.$buscar.'%')
                    ->orWhere('tipo_motor','like','%'.$buscar.'%')
                    ->orWhere('modelo','like','%'.$buscar.'%');
      
    }

}
