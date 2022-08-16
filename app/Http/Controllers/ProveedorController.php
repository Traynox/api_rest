<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Proveedor;
class ProveedorController extends Controller
{
   
    public function index()
    {
        $proveedores=Proveedor::all();
       
       if($proveedores){
           return response()->json(['ok'=>true,
                                    'data'=>$proveedores,
                                    'msg'=>''],200);
       }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontraron proveedores'],404);
            }
        
        }

   
    public function store(Request $request)
    {
        
        $proveedor=Proveedor::create($request->all());
        
        if($proveedor){
            return response()->json(['ok'=>true,
                                     'data'=>$proveedor,
                                     'msg'=>''],201);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se pudo crear el proveedor'],404);
        }

    }


    public function show($id)
    {
        $proveedor=Proveedor::find($id);

        if($proveedor){
            return response()->json(['ok'=>true,
                                     'data'=>$proveedor,
                                     'msg'=>''],200);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontro el proveedor'],404);
        }
    }

   
    public function update(Request $request,$id)
    {
        $proveedor=Proveedor::find($id);

        if($proveedor){
            $proveedor->update($request->all());
            return response()->json(['ok'=>true,
                                     'data'=>$proveedor,
                                     'msg'=>''],201);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontró el proovedor'],404);
        }
    }

  
    public function destroy($id)
    {
        
        $proovedor = Proveedor::destroy($id);
        if($proovedor){
            return response()->json(['ok'=>true,
                                     'data'=>$proovedor,
                                     'msg'=>'proveedor eliminado'],200);
        }else{
            return response()->json(['ok'=>false,
                                     'data'=>[],
                                     'msg'=>'No se encontró el proveedor'],404);
        }

    }

    public function indexLimit($limit)
    {

        // $proveedores=Proveedor::limit($limit)->get();
        $proveedores=Proveedor::limit($limit)->get();
            if($proveedores){
            return response()->json(['ok'=>true,
                                    'data'=>$proveedores,
                                    'msg'=>''],200);
            }else{
            return response()->json(['ok'=>false,
                                    'data'=>[],
                                    'msg'=>'No se encontraron proveedores'],404);
            }

    }

    public function indexFilter($paginate,$buscar='')
    {

        // $proveedores=Proveedor::limit($limit)->get();
        $proveedores=Proveedor::filter($buscar)->paginate($paginate);
            if($proveedores){
            return response()->json(['ok'=>true,
                                    'data'=>$proveedores,
                                    'msg'=>''],200);
            }else{
            return response()->json(['ok'=>false,
                                    'data'=>[],
                                    'msg'=>'No se encontraron proveedores'],404);
            }

    }
}
