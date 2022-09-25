<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|max:50',
            'short_description' => 'nullable|string|max:200',
            'description'       => 'nullable|string',
            'tags'              => 'nullable|json',
            'notifications'     => 'required|boolean',
            'assignee_id'       => 'nullable|numeric|exists:assignees',
            'status_id'         => 'required|numeric|exists:statuses',
            'stage_id'          => 'required|numeric|exists:stages',
            'parent_task_id'    => 'nullable|numeric|exists:tasks',
            'original_due_at'   => 'nullable|date',
            'due_at'            => 'nullable|date',
        ];
    }
}
