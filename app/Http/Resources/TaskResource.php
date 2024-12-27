<?php

namespace App\Http\Resources;
// use  Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

        // return [
        //     //
        //     'title'=> 'required|max:255',
        //     'scheduled_at'=> 'nullable|date',
        //     'due_at'=> 'nullable|date',
        //     'project_id'=>
        //     // 'nullable|date|max:255',
        //    [
        //       'nullable',
        //         Rule::in(Auth::user()->membershaps->pluck('id'))
        //     ],
        // ];



    }
}
