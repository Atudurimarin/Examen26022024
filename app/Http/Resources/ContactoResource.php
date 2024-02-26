<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'type' => 'contactos',
                'id' => $this->resource->getRouteKey(),
                'attributes' => [
                    'nombre' => $this->resource->nombre,
                    'tel'=> $this->resource->tel,
                    'num_libros' => $this->resource->num_libros,
                    'fecha_nacimiento' => $this->resource->fecha_nacimiento
                ],
                'links'=>[
                    'self' => route('api.v1.contactos', $this->resource)
                ]
            ]
        ];
    }

    public function toResponse($request)
    {
        return parent::toResponse($request)->withHeaders([   // PARA DEVOLVER LOCATION EN LA CABECERA
            'Location' => route('api.v1.contactos.show', $this->resource)
        ]);
    }
}
