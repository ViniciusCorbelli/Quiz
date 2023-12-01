<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'nullable|max:1024|mimes:png,jpg,jpeg,gif',
            'answer1' => 'required|min:1',
            'answer2' => 'required|min:1',
            'answer3' => 'required|min:1',
            'answer4' => 'required|min:1',
            'correct_answer' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'quesiton' => 'Pergunta',
            'image' => 'Imagem da pergunta',
            'answer1' => '1. opção',
            'answer2' => '2. opção',
            'answer3' => '3. opção',
            'answer4' => '4. opção',
            'correct_answer' => 'Responsta correta',
        ];
    }
}
