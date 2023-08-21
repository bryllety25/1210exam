<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'         => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/',  
        ];
    }

    public function messages()
    {
        return[
            'name.required'   => ['title'=>'Invalid name','message'=>'The name field is required.'],
            'email.required'        => ['title'=>'Invalid email','message'=>'The email address field is required.'],
            'email.unique'          => ['title'=>'Invalid email','message'=>'This email address has already been taken'],
            'email.email'           => ['title'=>'Invalid email','message'=>'Invalid email address format'],
            'password.required'     => ['title'=>'Invalid password','message'=>'The password field is required.'],
            'password.regex'        => ['title'=>'Invalid password','message'=>'Password must contain at least 1 lowercase, 1 uppercase, and 1 digit.'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
      $message = [];
      $error = $validator->errors();
        foreach((array) $error as $validator){
          if(is_array($validator)){
            $list = array_keys($validator);
            foreach($list as $l)
            array_push($message,$validator[$l][0]);
          }
        }

        throw new HttpResponseException(response()->json($message, 422));
    }
}
