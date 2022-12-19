<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SystemUserResource extends JsonResource
{
    /*
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'name'=> $this->name,
            'middlename'=> $this->middlename,
            'surname'=> $this->surname,
            'email'=> $this->email,
            'email_verified_at'=> $this->email_verified_at,
            'password'=> $this->password,
            'phone'=> $this->phone,
            'language'=> $this->language,
            'remember_token'=> $this->remember_token,
        ];
    }
}
