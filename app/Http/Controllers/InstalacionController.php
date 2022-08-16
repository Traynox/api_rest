<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Instalacion;
class InstalacionController extends Controller
{
    public function index()
    {
       $instalaciones=Instalacion::with(['motores','cliente'])->get();

       if($instalaciones){
           return response()->json(['ok'=>true,
                                    'data'=>$instalaciones,
                                    'msg'=>''],200);
       }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontraron instalaciones'],404);
            }
        
        }

   
    public function store(Request $request)
    {
  
        try {
            
            //TRY CATCH
            $instalaciones=instalacion::create($request->all());

            $id_motores = $request->id_motores;
            $precios = $request->precios;
            $cantidades = $request->cantidades;

        if($instalaciones){

            foreach ($id_motores as $key => $motor) {
                    
                $data[$key]=array('id_motor'=>$motor,'cantidad'=>$cantidades[$key],'precio'=>$precios[$key]);
             }
             //END FOR EARCH

                $instalaciones->motores()->attach($data);
           
            return response()->json(['ok'=>true,
                                     'data'=>$instalaciones,
                                     'msg'=>''],201);

        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se pudo crear la instalacion'],404);
        }


        //END TRY CATCH
        } catch (\Throwable $e) {
            instalacion::destroy($instalaciones->id_instalacion);

            return response()->json(['ok'=>false,
                                     'data'=>[], 
                                     'msg'=>' Ocurrio un error en la base de datos verifique que existan los datos insertados '.$e],500);
        } 
    }

    public function show($id)
    {
        $instalacion=instalacion::with(['motores','cliente'])->find($id);

        if($instalacion){
            return response()->json(['ok'=>true,
                                     'data'=>$instalacion],200);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontro la instalacion'],404);
        }
    }

   
    public function update(Request $request,$id)
    {
        $instalacion=instalacion::find($id);

       try {
           
        if($instalacion){
            
            $id_motores = $request->id_motores;
            $precios = $request->precios;
            $cantidades = $request->cantidades;

            $instalacion->update($request->all());
            
            foreach ($id_motores as $key => $motor) {
         
                $instalacion->motores()->updateExistingPivot($motor,['cantidad'=>$cantidades[$key],'precio'=>$precios[$key]]);
            }

            return response()->json(['ok'=>true,
                                     'data'=>$instalacion,
                                     'msg'=>''],201);

        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontró la instalacion'],404);
        }

        //END TRY CAHCH
       } catch (\Throwable $e) {

        
        return response()->json(['ok'=>false,
                                 'data'=>[], 
                                 'msg'=>'Ocurrio un error en la base de datos al actualizar,  verifique los datos '.$e],500);
       }
    }

  
    public function destroy($id)
    {
        
        $instalacion=Instalacion::destroy($id);

        if($instalacion){
        return response()->json(['ok'=>true,
                                 'data'=>$instalacion,
                                 'msg'=>'instalacion eliminada'],200);
         }else{
        return response()->json(['ok'=>false,
                                 'data'=>[], 
                                 'msg'=>'No se encontro instalacion'],404);
        }
    }

    public function indexLimit($limit)
    {
       
        // $instalaciones=Instalacion::with('motores')->limit($limit)->get();
        $instalaciones=Instalacion::with(['motores','cliente'])->paginate($limit);
        if($instalaciones){
            return response()->json(['ok'=>true,
                                     'data'=>$instalaciones,
                                     'msg'=>''],200);
        }else{
             return response()->json(['ok'=>false,
                                      'data'=>[],
                                      'msg'=>'No se encontraron instalaciones'],404);
             }
    }

    public function indexFilter($paginate,$buscar='')
    {
      
        // $instalaciones=Instalacion::with('motores')->limit($limit)->get();
        $instalaciones=Instalacion::with(['motores','cliente'])->filter($buscar)->paginate($paginate);
        if($instalaciones){
            return response()->json(['ok'=>true,
                                     'data'=>$instalaciones,
                                     'msg'=>''],200);
        }else{
             return response()->json(['ok'=>false,
                                      'data'=>[],
                                      'msg'=>'No se encontraron instalaciones'],404);
             }
    }


}
