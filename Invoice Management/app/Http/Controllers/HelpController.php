<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class HelpController extends Controller
{
	
	public function __construct() {
		$this->middleware('auth');
		
	}
	
	//http://stackoverflow.com/a/18680869
	private function getStringBetween($str,$from,$to)
{
		$sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
		return substr($sub,0,strpos($sub,$to));
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$client = new Requests\CreateClientRequest();
		$invoice = new Requests\CreateInvoiceRequest();
		$service = new Requests\CreateServiceRequest();
		
		$rules = array_merge($client->rules(),$invoice->rules(),$service->rules());
		$range = [];
		
		foreach($rules as $key => $val ) {
			if(strPos($val, 'min:') !== FALSE) {
					$range[$key]['min'] = $this->getStringBetween($val,'min:','|');
					
					if($range[$key]['min'] === ""){
						$start =  strpos($val,'min:');
						$range[$key]['min'] = substr($val,$start + 4);
					}
					
			}
			if(strPos($val, 'max:') !== FALSE) {
					$range[$key]['max'] = $this->getStringBetween($val,'max:','|');
					
					if($range[$key]['max'] === ""){
						$start =  strpos($val,'max:');
						$range[$key]['max'] = substr($val,$start + 4);
					}
			}
		}
		$rules['range'] = $range;
		
		//return dd($rules);
		
		view()->share('rules', $rules);
		
		
		
        return view('help.index');
    }
	
	

    
}
