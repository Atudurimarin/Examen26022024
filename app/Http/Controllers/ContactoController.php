<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactoResource;
use App\Models\Contacto;
use COM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactos = Contacto::query()
        ->allowedSorts(['nombre', 'tel'])
        ->jsonPaginate();

        return ContactoResource::collection($contactos); //SE HACE UNA COLECCIÓN DE TODOS LOS RESOURCES DE TODOS LOS CONTACTOS
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        $contacto= Contacto::create([   // SE PASAN LOS DATOS DE LOS ATRIBUTOS EN UN ARRAY
            'nombre' => $request->input('nombre'),
            'tel' => $request->input('tel'),     
            'num_libros' => $request->input('num_libros'),
            'fecha_nacimiento' => $request->input('fecha_nacimiento')
        ]);

        return ContactoResource::make($contacto); // DEBEMOS MODIFIAR EL CONTACTO RESOURCE PARA QUE DEVUELVA EL HEADER LOCATION
    }

    /**
     * Display the specified resource.
     */
    public function show(Contacto $contacto)
    {
        return ContactoResource::make($contacto);
    }


 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contacto $contacto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacto $contacto)
    {
        $contacto->delete();
        return response()->json([
            "success" => "Contacto ".$contacto->id." was deleted successfully"
        ]);
        
    }
}
