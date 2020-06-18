<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Client;
use App\Address;
use Auth;
use DB;

class ClientController extends Controller
{
	
	private $resultsPerPage;
	private $userID;
	
	public function __construct() {
		$this->middleware('auth');
		
		$this->resultsPerPage = env('RESULTS_PER_PAGE');
		if(Auth::user())
			$this->userID = Auth::user()->id;
		else
			$this->userID = -1;
		
	}
	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = $this->search($request);
		$rows->appends(['search' => $request->input('search', '')]);

		return view('clients.search')->with('rows',$rows);
    }
	
	private function search(Request $request){
		$search = '%'.$request->input('search', '').'%';
		
		$rows = Client::Where('user_id', $this->userID )
		->where(function ($query) use ($search){
					$query->whereHas('address', function ($query) use ($search){
									$query->where('unitNumber', 'LIKE', $search )
									->orWhere('street', 'LIKE', $search )
									->orWhere('city', 'LIKE', $search )
									->orWhere('province', 'LIKE', $search )
									->orWhere('postalCode', 'LIKE', $search );
							})->orWhere('companyName', 'LIKE', $search )
							->orWhere('clientName', 'LIKE', $search )
							->orWhere('email', 'LIKE', $search )
							->orWhere('phone', 'LIKE', $search );
				})
				->orderBy('companyName', 'ASC')
				->orderBy('clientName', 'ASC')
				->paginate($this->resultsPerPage);
		
		
		
		return $rows;
		
		
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateClientRequest $request)
    {
        $client = new Client([
		'companyName' => $request->input('companyName'),
		'clientName' => $request->input('clientName'),
		'email' => $request->input('email'),
		'phone' => $request->input('phone')
		]);
		
		$address = new Address([
		'unitNumber' => $request->input('address.unitNumber'),
		'street' => $request->input('address.street'),
		'city' => $request->input('address.city'),
		'province' => $request->input('address.province'),
		'postalCode' => $request->input('address.postalCode')
		]);
		
		
		DB::transaction(function() use ($client, $address) {
			$address->save();
			
			$client->address_id = $address->id;
			$client->user_id = $this->userID;
			$client->save();	
				
				
			$address->client_id = $client->id;
			$address->save();

		});
		
		$data = Client::with('address')->find($client->id);
		
		return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		
        $rows = Client::with('address')
		->where('id', $id )
		->where('user_id', $this->userID )
		->firstOrFail();
		
		//return $rows;
		return view('clients.view')->with('rows',$rows);
    }
	
	/**
     * Display the specified resource with modal divs hidden.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPlain(Request $request)
    {
		$id = $request->input('id');
		
        $rows = Client::with('address')
		->where('id', $id )
		->where('user_id', $this->userID )
		->firstOrFail();
		
		//return $rows;
		return view('clients.view')->with('rows',$rows)->with('hideModal',true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rows = Client::with('address')
		->where('id', $id )
		->where('user_id', $this->userID )
		->firstOrFail();
		
		return view('clients.edit')->with('rows',$rows);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Requests\CreateClientRequest $request)
    {
        $client = Client::Where('id', $id )
		->where('user_id', $this->userID )
		->firstOrFail();
		
		$client->companyName = $request->input('companyName');
		$client->clientName = $request->input('clientName');
		$client->email = $request->input('email');
		$client->phone = $request->input('phone');
		
		$client->address->unitNumber = $request->input('address.unitNumber');
		$client->address->street = $request->input('address.street');
		$client->address->city = $request->input('address.city');
		$client->address->province = $request->input('address.province');
		$client->address->postalCode = $request->input('address.postalCode');
		
		$client->push();
		
		$data = Client::with('address')->find($id);
		
		return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$errorMsg = "Error: Object does not exist or you do not have the required permissions to delete it";
		
		$client = Client::Where('id', $id )
			->where('user_id', $this->userID )
			->firstOrFail();

		if(is_null($client))
			return $errorMsg;
		
		try{
			$client->address->delete();
			$client->delete();
			
		} catch(\Illuminate\Database\QueryException $ex){ 
			if($ex->errorInfo[0] == '23000') {
				return json_encode(['status' => 'error', 'message' => 'You cannot delete a client that has an invoice']);
			}
			return json_encode(['status' => 'error', 'message' => 'An unknown error occured. Please try again.']);
			
		}
		
		return json_encode(['status' => 'success', 'message' => 'The client has been deleted.']);
    }
}
