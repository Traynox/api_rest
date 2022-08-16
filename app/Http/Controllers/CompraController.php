<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Compra;
use App\models\Proveedor;
use App\models\Persona;

class CompraController extends Controller
{
    public function index()
    {

        $compra=Compra::with(['motores','proveedor'])->get();
   
       if($compra){
           return response()->json(['ok'=>true,
                                    'data'=>$compra,
                                    'msg'=>''],200);
       }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontraron compras'],404);
            }
        
        }

   
    public function store(Request $request)
    {
        // $id_motores=$request->id_motores;
        // $precios=$request->precios;
        // $cantidades=$request->cantidades;
        $data=[];
        
        $todos=$request->todos;
        
        
        try {
            //TRY CATCH
            
            $compra=Compra::create([
            'fecha'=>$request->fecha,
            'factura_fisica'=>$request->factura_fisica,
            'id_proveedor'=>$request->id_proveedor
            ]);
        
            if($compra){
                
                foreach ($todos as $key => $todo) {
                    
                $data[$key]=array('id_motor'=>$todo["id_motor"],'cantidad'=>$todo["cantidad"],'precio'=>$todo["precio"]);
             }
             //END FOR EARCH

                $compra->motores()->attach($data);
           
                return response()->json(['ok'=>true,
                                         'data'=>$compra,
                                         'msg'=>''],201);
            }else{
                return response()->json(['ok'=>false,
                                         'data'=>[],
                                         'msg'=>'No se pudo crear la compra'],404);
            }

            //END TRY CATCH
        } catch (\Throwable $e) {
            compra::destroy($compra->id_compra);

            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>' Ocurrio un error en la base de datos verifique que existan los datos insertados'.$e],500);
        }

    }


    public function show($id)
    {
        $compra=Compra::with(['motores','proveedor'])->find($id);

        if($compra){
            return response()->json(['ok'=>true,
                                     'data'=>$compra,
                                     'msg'=>''],200);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontro la compra'],404);
        }
    }

    public function update(Request $request,$id)
    {

      try {
         //TRY CATCH
        //PARSEAR VALORES DE UN ARRAY
        // $id_motores = array_map('intval', $request->id_motores);
        // $precios = array_map('intval', $request->precios);
        // $cantidades = array_map('intval', $request->cantidades);
   
         
         $compra=Compra::find($id);

        if($compra){

                 
            $id_motores = $request->id_motores;
            $precios = $request->precios;
            $cantidades = $request->cantidades;

            $compra->update($request->only('fecha','id_proveedor'));

            foreach ($id_motores as $key => $motor) {
         
                $compra->motores()->updateExistingPivot($motor,['cantidad'=>$cantidades[$key],'precio'=>$precios[$key]]);
            }


                                        //actualiza todos los datos de la tabla pivote donde id_motores sea igual
            // $compra->motores()->updateExistingPivot($id_motores,['cantidad'=>100,'precio'=>200]);
            return response()->json(['ok'=>true,
                                     'data'=>$compra,
                                     'msg'=>''],201);

        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontró la compra'],404);
        }

        //END TRY CATCH
        
      } catch (\Throwable $e) {
         
        return response()->json(['ok'=>false,
                                 'data'=>[],
                                 'msg'=>'Ocurrio un error en la base de datos al actualizar,  verifique los datos'.$e],500);

      }
    }

  
    public function destroy($id)
    { 
        $compra=Compra::destroy($id);
        if($compra){
        return response()->json(['ok'=>true,
                                 'data'=>$compra,
                                 'msg'=>'compra eliminada'],200);
        }else{
        return response()->json(['ok'=>false, 
                                 'data'=>[],
                                 'msg'=>'No se encontro la compra'],404);
        }
    }

    public function indexLimit($limit)
    {
    
        // $compra=Compra::with(['motores','proveedor'])->limit($limit)->get();

        $compra=Compra::with(['motores','proveedor'])->paginate($limit);
        if($compra){
            return response()->json(['ok'=>true,
                                     'data'=>$compra,
                                     'msg'=>''],200);
        }else{
             return response()->json(['ok'=>false,
                                      'data'=>[],
                                      'msg'=>'No se encontraron compras'],404);
             }
    }

    public function indexFilter($paginate,$buscar='')
    {
    
        // $compra=Compra::with(['motores','proveedor'])->limit($limit)->get();
        // $buscar=$request->buscar;
        $compra=Compra::with(['motores','proveedor'])->filter($buscar)->paginate($paginate);

        if($compra){
            return response()->json(['ok'=>true,
                                     'data'=>$compra,
                                     'msg'=>''],200);
        }else{
             return response()->json(['ok'=>false,
                                      'data'=>[],
                                      'msg'=>'No se encontraron compras'],404);
             }
    }

}
