<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryStoreRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:128'],
            // usamos alpha_dash para que no haya caracteres extraños como "@", "/", acentos o espacios(ya que es una etiqueta) y el unique lo ponesmos porque en la BBDD esta definido como campo unico
            'slug' => ['required', 'string', 'max:128', 'alpha_dash', Rule::unique('categories', 'slug')], 
            'visible' => ['nullable', 'boolean'],
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
