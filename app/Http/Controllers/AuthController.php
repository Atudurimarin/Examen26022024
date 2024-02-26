<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use \stdClass;


class AuthController extends Controller
{
   
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function register(Request $request){
        
        $validate = FacadesValidator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email',            // VALIDAR DATOS
            'password' => 'required|min:8|max:12',
            'rol' => 'required'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());   // SI FALLA VALIDACIÓN LANZAR ERROR
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,                     // SI LA VALIDACIÓN ES CORRECTA CREAR USUARIO
            'password' => Hash::make($request->password),
            'rol' => $request->rol
        ]);

        $token = $user->createToken('auth_token', [], now()->addDay())->plainTextToken; // CREAR TOKEN

        return response()->json([
            'user' => $user,                // DEVOLVER RESPUESTA CON TOKEN
            'Access_token' => $token
        ]);
    }

    public function login (Request $request){

        if(! Auth::attempt($request->only('email','password'))){
            return response()->json([
                'message' => 'Unauthorized'   // SI FALLA LA AUTENTICACIÓN DEVOLVER MENSAJE DE ERROR
            ], 401);
        }

        $user = User::whereEmail($request->email)->first();

        if($user->rol === 'admin'){  //SOLO LOS USUARIOS CON EL ROL DE ADMIN TENDRÁN PERMISOS PARA CREAR Y BORRAR
            $token = $user->createToken('admin_token', ['create','delete'], now()->addDay())->plainTextToken;
        }

        else{
            $token = $user->createToken('user_token', [], now()->addDay())->plainTextToken; //DURACION TOKEN 24H
        }

        return response()->json([
            'message' => 'Hola '.$user->name.' Bienvenido de nuevo!',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

  
        
}
