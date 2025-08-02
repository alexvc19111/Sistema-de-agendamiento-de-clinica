<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerarTurnosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
        ];
    }
}