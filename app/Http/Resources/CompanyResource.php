<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            "name" => (string)$this->name,
            "email" => (string)$this->email,
            "logo" => (string)$this->logo,
            "image" => (string)$this->logo_image,
            "website" => (string)$this->website
        ];
    }
}
