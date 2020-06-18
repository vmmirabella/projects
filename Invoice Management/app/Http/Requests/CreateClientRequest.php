<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateClientRequest extends Request
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
	
	
	/*
	* Custom field names for error messages
	*/
	public function attributes(){

        return [
            'address.unitNumber' => 'Unit Number',
		'address.street' => 'Street',
		'address.city' => 'City',
		'address.province' => 'Province',
		'address.postalCode' => 'Postal Code'
        ];

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$rules = [
        'clientName' => 'required|alpha_spaces',
		'email' => 'required|email|',
		'phone' => 'required|min:4',
		'address.unitNumber' => 'numeric|min:0',
		'address.street' => 'required|min:1|alpha_num_spaces',
		'address.city' => 'required|alpha_spaces',
		'address.province' => 'required|alpha_spaces',
		'address.postalCode' => 'required|alpha_num_spaces'
        ];
		
		$id = $this->route('clients'); 

		switch($this->method()){
			case 'GET':
			case 'DELETE':
			case 'POST':
			case 'PUT':
				$rules['email'] = 'required|email|unique:client,email';
				break;
			case 'PATCH':
				$rules['email'] = 'required|email|unique:client,email,'.$id;
				break;
		}
		
		
		
        return $rules;
    }
}
