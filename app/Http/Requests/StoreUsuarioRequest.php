<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return $this->user()?->username === 'Administrador';
        //return true; poner true en caso de que se tengan roles
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    //Validacion de los datos que se envian al crear un usuario 
    public function rules(): array
    {
        return [
            //
            'username' => 'required|string|max:50|unique:usuarios',
            'password' => 'required|string|min:6',
            'persona_id' => 'required|exists:personas,id'
        ];
    }
    public function messages()
    {
        return[
            'username.unique'=> 'El nombre de usuario ya existe',
            'persona_id.exists'=> 'La persona seleccionada no existe o no es valida',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'persona_id.required' => 'El ID de la persona es obligatorio.',
            'username.max' => 'El nombre de usuario no puede tener más de 50 caracteres.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.'
        ];
    }
}
