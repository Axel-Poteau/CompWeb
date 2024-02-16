<?php

namespace App\Http\Resources;

use App\Http\Controllers\Api\SalleController;
use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request) {
        return parent::toArray($request);
    }
    public function show($id) {
        $salle = Salle::findOrFail($id);
        return new SalleController($salle);
    }
    public function index() {
        $salles = Salle::all();
        return SalleResource::collection($salles);
    }


}
