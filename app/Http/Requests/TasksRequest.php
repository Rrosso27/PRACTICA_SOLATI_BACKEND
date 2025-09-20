<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TasksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $taskId = $this->route('task') ?? $this->route('id'); // Obtiene el ID de la ruta para updates

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];

        // Si es una actualización, agregar la regla unique con ignore
        if ($taskId) {
            $rules['title'] .= '|unique:tasks,title,' . $taskId;
        } else {
            $rules['title'] .= '|unique:tasks,title';
        }

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'title.unique' => 'Ya existe una tarea con este título.',
            'title.max' => 'El título no puede tener más de 255 caracteres.',
        ];
    }


      /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $validator->errors()
        ], 422));
    }

}
