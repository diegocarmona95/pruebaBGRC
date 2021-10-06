<?php

namespace App\Http\Controllers;
use App\Models\Vehiculo;
use App\Models\HistoricoPersonaVehiculo;

use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function registrarVehiculo(Request $request){
        //dd($request->vehiculo);
        $errores = [];
        try {
            $historico = new HistoricoPersonaVehiculo;
            if($request->vehiculo['id'] == 0){
                $vehiculo = new Vehiculo;
            }else{
                $vehiculo = Vehiculo::find($request->vehiculo['id']);
                if( ($request->vehiculo['marca'] !== $vehiculo->marca) || ($request->vehiculo['modelo'] !== $vehiculo->modelo) || ($request->vehiculo['dueno'] !== $vehiculo->dueno) || ($request->vehiculo['precio'] !== $vehiculo->precio) ){
                    $historico->persona_id = $request->vehiculo['dueno'];
                    $historico->vehiculo_id = $vehiculo->id;
                    $historico->precio = $vehiculo->precio;
                    $historico->save();
                }
            }
            
            $vehiculo->marca = $request->vehiculo['marca'];
            $vehiculo->modelo = $request->vehiculo['modelo'];
            $vehiculo->anno = $request->vehiculo['anno'];
            $vehiculo->dueno = $request->vehiculo['dueno'];
            $vehiculo->precio = $request->vehiculo['precio'];
            $vehiculo->save();
            $id_vehiculo = $vehiculo->id;

            if($request->vehiculo['id'] == 0){
                $historico->persona_id = $request->vehiculo['dueno'] == null ? 0 : $request->vehiculo['dueno'];
                $historico->vehiculo_id = $vehiculo->id;
                $historico->precio = $vehiculo->precio;
                $historico->save();
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

    public function historicoVehiculosPersona(Request $request){
        $errores = [];
        try {
            $query_builder = HistoricoPersonaVehiculo::orderBy('id', 'asc')
            ->with(array('personas' => function($query) {
                $query->select('id','nombre', 'apellidos');
            }))
            ->with(array('vehiculos' => function($query2) {
                $query2->select('id','marca', 'modelo', 'anno');
            }));
            if($request->dueno){
                $query_builder->where('persona_id', $request->dueno);
            }
            $historico_vehiculo_persona = $query_builder->get();
        } catch (\Exception $e) {
            $errores[] = $e->getMessage();
        }
        if($errores){
            $respuesta['errores'] = $errores;
        }else{
            $respuesta['status'] = 'ok';
            $respuesta['historico_vehiculo_persona'] = $historico_vehiculo_persona;
        }
        return response()->json($respuesta);
    }

    public function vehiculosPorAnno(Request $request){
        $errores = [];
        try {
            $vehiculos = Vehiculo::select('anno')->selectRaw('COUNT(*) as cantidad_vehiculos')->groupBy('anno')->get();
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

    
}
