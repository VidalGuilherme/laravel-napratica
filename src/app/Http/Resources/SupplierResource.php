<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->supplier_type,
            'name' => $this->personal_name ?? $this->company_name,
            'nick' => $this->nickname ?? $this->fantasy_name,
            'document' => $this->cpf ?? $this->cnpj,
            'status' => $this->status ? 'Sim' : 'Não'
        ];
    }
}
