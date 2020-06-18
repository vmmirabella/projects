<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateInvoiceRequest extends Request
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

		$attributes = ['client_id' => 'Client Name'];
		
		foreach($this->request->get('invoiceLineItems') as $key => $val)
		{
			$attributes['invoiceLineItems.'.$key.'.totalHours'] = 'Total Hours Line #' . $key;
			$attributes['invoiceLineItems.'.$key.'.name'] = 'Service Name #' . $key;
			$attributes['invoiceLineItems.'.$key.'.flatRate'] = 'Flat Rate Line #'.$key;

		}
		
		
        return $attributes;

    }
	
	public function messages()
	{
		$msgs = [];
		
		foreach($this->request->get('invoiceLineItems') as $key => $val)
		{
			$msgs['invoiceLineItems.'.$key.'.name.not_in'] = 'Service Name #'.$key.' must be unique. You cannot have duplicate services.';
			$msgs['invoiceLineItems.'.$key.'.flatRate.required'] = 'You must hit enter and confirm your choice after selecting Service Name #'.$key.' from the drop down.';
		}
		
		return $msgs;
	}
	
	private function exceptIn($except) {
		$str = "";

		foreach($this->request->get('invoiceLineItems') as $key => $val){
			if($key != $except){
				$str .= $val['name'] . ',';	
			}
		}
		
		return rtrim($str, ',');
		
	}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

		$rules = [ 
		'taxRate' => 'required|numeric|min:0',
		'dueDate' => 'required|date_format:"d/m/Y"|after:today',
		
        ];
		
		$id = $this->route('invoices'); 

		switch($this->method()){
			case 'GET':
			case 'DELETE':
			case 'POST':
			case 'PUT':
				$rules['client_id'] = 'required|min:1';
				$rules['invoiceNumber'] = 'required|alpha_num|size:12|unique:invoice,invoiceNumber';
				break;
			
			case 'PATCH':
				$rules['client_id'] = 'min:1';
				$rules['invoiceNumber'] = 'required|alpha_num|size:12|unique:invoice,invoiceNumber,'.$id;

				break;
		}
		
		if($this->request->get('invoiceLineItems')) {
			foreach($this->request->get('invoiceLineItems') as $key => $val)
			  {
				$rules['invoiceLineItems.'.$key.'.totalHours'] = 'required|numeric|min:1';
				$rules['invoiceLineItems.'.$key.'.flatRate'] = 'required|numeric|min:1';
				$rules['invoiceLineItems.'.$key.'.name'] = 'required|alpha_spaces|not_in:'. $this->exceptIn($key);
			
			  }
		} else {
			$rules['invoiceLineItems.1.totalHours'] = 'required|numeric|min:1';
			$rules['invoiceLineItems.1.flatRate'] = 'required|numeric|min:1';
			$rules['invoiceLineItems.1.name'] = 'required|alpha_spaces';
			
		}
		

		return $rules;
	}
	
	
		
}
