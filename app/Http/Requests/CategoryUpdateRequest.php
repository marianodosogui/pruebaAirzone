<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
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
        $categoryId = $this->route('category')?->id ?? $this->route('category');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:128'],
            'slug' => [
                'sometimes',
                'required',
                'string',
                'max:128',
                'alpha_dash',// usamos alpha_dash para que no haya caracteres extraños como "@", "/", acentos o espacios(ya que es una etiqueta)
                Rule::unique('categories', 'slug')->ignore($categoryId), // el unique lo ponesmos porque en la BBDD esta definido como campo unico
            ],
            'visible' => ['sometimes', 'nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // si viene como "true"/"false" string, boolean() lo normaliza.
        if ($this->has('visible')) {
            $this->merge(['visible' => filter_var($this->visible, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)]);
        }
    }
}
