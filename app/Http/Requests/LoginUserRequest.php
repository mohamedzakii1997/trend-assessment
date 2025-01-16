<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function authorize()
    {
        // Ensure the user is allowed to make this request
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email'
            ],
            'password' => 'required|string',
        ];
    }


}
