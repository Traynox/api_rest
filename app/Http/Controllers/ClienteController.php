<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Cliente;
class ClienteController extends Controller
{
    
    public function index()
    {
    
       $clientes=Cliente::all();
       if($clientes){
           return response()->json(['ok'=>true,
                                    'data'=>$clientes,
                                    'msg'=>''],200);
       }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontraron clientes'],404);
            }
        
        }

  
    public function store(Request $request)
    {
   
        $cliente=Cliente::create($request->all());
        
        if($cliente){
            return response()->json(['ok'=>true,
                                     'data'=>$cliente,
                                     'msg'=>'El cliente se creo correctamente'],201);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se pudo crear el cliente'],404);
        }

    }

   
    public function show($id)
    {
        $cliente=Cliente::find($id);
        if($cliente){
            return response()->json(['ok'=>true,
                                     'data'=>$cliente,
                                     'msg'=>''],200);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontro el cliente'],404);
        }
    }

    
    public function update(Request $request,$id)
    {
        
        $cliente=Cliente::find($id);
       
        if($cliente){
        
             $cliente->update($request->all());

            return response()->json(['ok'=>true,
                                     'data'=>$cliente,
                                     'msg'=>''],201);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontró el cliente'],404);
        }
    }

  

    public function destroy($id)
    {
        $cliente=Cliente::destroy($id);
        if($cliente){
            return response()->json(['ok'=>true,
                                     'data'=>$cliente,
                                     'msg'=>''],200);
        }else{
        return response()->json(['ok'=>false,
                                 'data'=>[],
                                 'msg'=>'Cliente eliminado'],200);
        }
    }


    public function indexLimit($limit){

        $clientes=Cliente::paginate($limit);
        if($clientes){
            return response()->json(['ok'=>true,
                                     'data'=>$clientes,
                                     'msg'=>''],200);
        }else{
             return response()->json(['ok'=>false,
                                      'data'=>[],
                                      'msg'=>'No se encontraron clientes'],404);
             }
    }



    public function indexFilter($paginate,$buscar=''){

       //request $request,
       
        $clientes=Cliente::filter($buscar)->paginate($paginate);

        if($clientes){
            return response()->json(['ok'=>true,
                                     'data'=>$clientes,
                                     'msg'=>''],200);
        }else{
             return response()->json(['ok'=>false,
                                      'data'=>[],
                                      'msg'=>'No se encontraron clientes'],404);
             }
    }
}
