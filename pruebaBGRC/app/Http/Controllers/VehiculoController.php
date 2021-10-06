<?php

namespace App\Http\Controllers;
use App\Models\Vehiculo;

use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function registrarVehiculo(Request $request){
        //dd($request->vehiculo);
        $errores = [];
        try {
            if($request->vehiculo['id'] == 0){
                $vehiculo = new Vehiculo;
            }else{
                $vehiculo = Vehiculo::find($request->vehiculo['id']);
            }
            $vehiculo->marca = $request->vehiculo['marca'];
            $vehiculo->modelo = $request->vehiculo['modelo'];
            $vehiculo->anno = $request->vehiculo['anno'];
            $vehiculo->dueno = $request->vehiculo['dueno'];
            $vehiculo->precio = $request->vehiculo['precio'];
            $vehiculo->save();
        } catch (\Exception $e) {
            $errores[] = $e->getMessage();
        }
        if($errores){
            $respuesta['errores'] = $errores;
        }else{
            $respuesta['status'] = 'ok';
        }
        return response()->json($respuesta);
    }

    public function listarVehiculos(Request $request){
        $errores = [];
        try {
            $vehiculos = Vehiculo::orderBy('marca', 'asc')->with(array('persona' => function($query) {
                $query->select('id','nombre', 'apellidos');
            }))->paginate($request->per_page);
        } catch (\Exception $e) {
            $errores[] = $e->getMessage();
        }
        if($errores){
            $respuesta['errores'] = $errores;
        }else{
            $respuesta['status'] = 'ok';
            $respuesta['vehiculos'] = $vehiculos;
        }
        return response()->json($respuesta);
    }

    public function eliminarVehiculo(Request $request){
        $errores = [];
        try {
            $vehiculo = Vehiculo::find($request->id);
            if($vehiculo){
                $vehiculo->delete();
            }else{
                $errores[] = 'No se ha encontrado el ID del vehiculo';
            }
        } catch (\Exception $e) {
            $errores[] = $e->getMessage();
        }
        if($errores){
            $respuesta['errores'] = $errores;
        }else{
            $respuesta['status'] = 'ok';
        }
        return response()->json($respuesta);
    }

    
}
