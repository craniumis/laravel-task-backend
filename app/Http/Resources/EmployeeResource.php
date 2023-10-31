<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => (int)$this->id,
            "first_name" => (string)$this->first_name,
            "last_name" => (string)$this->last_name,
            "full_name" => (string)$this->full_name,
            "company_id" => (int)$this->company_id,
            "company_name" => (string)$this->Company->name,
            "email" => (string)$this->email,
            "phone" => (string)$this->phone
        ];
    }
}
