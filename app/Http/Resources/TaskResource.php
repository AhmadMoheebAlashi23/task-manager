<?php

namespace App\Http\Resources;
// use  Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request):array
    {

        $data= parent::toArray(request: $request);
        $data['status']=$this->is_done ? 'finished' : 'open';
        return $data;

    }
}
