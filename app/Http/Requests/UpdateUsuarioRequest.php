<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize()
    {

        return true; // Personalizar esto despues para verificar roles o permisos
    }

    public function rules()
    {
        return [
            'username' => 'sometimes|required|string|max:50|unique:usuarios,username,' . $this->route('id'),
            'password' => 'sometimes|required|string|min:6',
            'persona_id' => 'sometimes|required|exists:personas,id',
        ];
    }
}
