<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Motor;
class MotorController extends Controller
{
    
    public function index()
    {
       $motores=Motor::with('compras')->get();
       if($motores){
           return response()->json(['ok'=>true,
                                    'data'=>$motores,
                                    'msg'=>''],200);
       }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontraron motores'],404);
            }
        
        }

   
    public function store(Request $request)
    {

        $motor=Motor::create($request->all());
        
        if($motor){
            return response()->json(['ok'=>true,
                                     'data'=>$motor,
                                     'msg'=>''],201);
        }else{
            return response()->json(['ok'=>false,'data'=>[],'msg'=>'No se pudo crear el motor'],404);
        }

    }


    public function show($id)
    {
        $motor=Motor::find($id);

        if($motor){
            return response()->json(['ok'=>true,
                                     'data'=>$motor,
                                     'msg'=>''],200);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontro el motor'],404);
        }
    }

    public function update(Request $request,$id)
    {
        $motor=Motor::find($id);

        if($motor){
            $motor->update($request->all());
            return response()->json(['ok'=>true,
                                     'data'=>$motor,
                                     'msg'=>''],201);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontró el motor'],404);
        }
    }

  
    public function destroy($id)
    { 
       $motor = Motor::destroy($id);
       if($motor){
           return response()->json(['ok'=>true,
                                    'data'=>$motor,
                                    'msg'=>'motor eliminado'],200);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontró el motor'],404);
        }
        
    }

    public function indexLimit($limit){

        // $motores=Motor::with('compras')->get();
        $motores=Motor::with('compras')->limit($limit)->get();
        // $motores=Motor::limit($limit)->get();
        if($motores){
            return response()->json(['ok'=>true,
                                     'data'=>$motores,
                                     'msg'=>''],200);
        }else{
             return response()->json(['ok'=>false,
                                      'data'=>[],
                                      'msg'=>'No se encontraron motores'],404);
             }
    }

    public function indexFilter($paginate,$buscar){

        // $motores=Motor::with('compras')->get();
        $motores=Motor::filter($buscar)->with('compras')->paginate($paginate);
        if($motores){
            return response()->json(['ok'=>true,
                                     'data'=>$motores,
                                     'msg'=>''],200);
        }else{
             return response()->json(['ok'=>false,
                                      'data'=>[],
                                      'msg'=>'No se encontraron motores'],404);
             }
    }


}
