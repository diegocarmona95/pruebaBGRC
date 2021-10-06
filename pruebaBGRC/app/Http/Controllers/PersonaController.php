<?php

namespace App\Http\Controllers;
use App\Models\Persona;

use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function listarPersonas(){
        $errores = [];
        try {
            $personas = Persona::orderBy('nombre', 'asc')->get();
        } catch (\Exception $e) {
            $errores[] = $e->getMessage();
        }
        if($errores){
            $respuesta['errores'] = $errores;
        }else{
            $respuesta['status'] = 'ok';
            $respuesta['personas'] = $personas;
        }
        return response()->json($respuesta);
    }

    public function listarPersonasTabla(Request $request){
        $errores = [];
        try {
            $personas = Persona::orderBy('id', 'asc')->paginate($request->per_page);
        } catch (\Exception $e) {
            $errores[] = $e->getMessage();
        }
        if($errores){
            $respuesta['errores'] = $errores;
        }else{
            $respuesta['status'] = 'ok';
            $respuesta['personas'] = $personas;
        }
        return response()->json($respuesta);
    }

    public function registrarActualizarPersona(Request $request){
        $errores = [];
        try {
            if($request->persona['id'] == 0){
                $persona = new Persona;
            }else{
                $persona = Persona::find($request->persona['id']);
            }
            $persona->nombre = $request->persona['nombre'];
            $persona->apellidos = $request->persona['apellidos'];
            $persona->correo = $request->persona['correo'];
            $persona->save();
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

    public function eliminarPersona(Request $request){
        $errores = [];
        try {
            $persona = Persona::find($request->id);
            if($persona){
                $persona->delete();
            }else{
                $errores[] = 'No se ha encontrado el ID de la persona';
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
