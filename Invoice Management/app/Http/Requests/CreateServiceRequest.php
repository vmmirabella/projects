<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateServiceRequest extends Request
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
		
		$rules = [
		'flatRate' => 'required|numeric|min:1',
		'hourlyRate' => 'numeric|min:0',
		'shortDescription' => 'max:80'
        ];
		
		$id = $this->route('services'); 

		switch($this->method()){
			case 'GET':
			case 'DELETE':
			case 'POST':
			case 'PUT':
				$rules['name'] = 'required|alpha_spaces|unique:service,name';
				break;
			case 'PATCH':
				$rules['name'] = 'required|alpha_spaces|unique:service,name,'.$id;
				break;
		}
		
		
		
        return $rules;
    }
}
