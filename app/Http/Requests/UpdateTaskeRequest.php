<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateTaskeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool{

    $task = $this->route('task');
    // dd(  $task->creator_id , Auth::id());
    return Auth::check() && $task && $task->creator_id === Auth::id();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules():array
    {
        return [
            'title' => 'sometimes|required|max:255',
            'is_done' => 'sometimes|boolean',
            'scheduled_at' => 'sometimes|nullable|date',
            'due_at' => 'sometimes|nullable|date',
            'project_id' => [
            'nullable',
             Auth::check() ? Rule::in(Auth::user()->memberships->pluck('id')) : 'nullable',
            ],

        ];
    }
}
