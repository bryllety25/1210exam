<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Enums\TaskStatus;
use Illuminate\Validation\Rules\Enum;

class TaskCreateRequest extends FormRequest
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
            'title'         => 'required',
            'description'         => 'string|nullable',
            'file'      => '',  
            'status'    => ['required',new Enum(TaskStatus::class)],
        ];
    }

    public function messages()
    {
        return[
            'title.required'   => ['title'=>'Invalid Title','message'=>'The title field is required.'],
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
