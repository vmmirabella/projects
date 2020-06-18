<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Service;
use Auth;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 private $resultsPerPage;
	 private $userID;
	 
	public function __construct() {
		$this->middleware('auth');
		
		if(Auth::user())
			$this->userID = Auth::user()->id;
		else
			$this->userID = -1;
		
		$this->resultsPerPage = env('RESULTS_PER_PAGE');
		
	}
	 
    public function index(Request $request)
    {
		$rows = $this->search($request);
		$rows->appends(['search' => $request->input('search', '')]);

		return view('services.search')->with('rows',$rows);
    }

    private function search(Request $request){
		$search = '%'.$request->input('search', '').'%';
		
		$rows = Service::Where('user_id', $this->userID )
		->where( 
			function($query) use ($search) {
				$query->where('name', 'LIKE', $search )
				->orWhere('shortDescription', 'LIKE', $search )
				->orWhere('flatRate', 'LIKE', $search )
				->orWhere('hourlyRate', 'LIKE', $search );
			}
			
		)
		->orderBy('name', 'ASC')
		->paginate($this->resultsPerPage);
		
		
		
		return $rows;
		
		
	}
	
	public function show($id){
		$rows = Service::Where('id', $id )
		->where('user_id', $this->userID )
		->firstOrFail();
		
		return view('services.view')->with('rows',$rows);
	}
	
	
	public function destroy($id){
		$service = Service::Where('id', $id )
		->where('user_id', $this->userID )
		->firstOrFail();
		
		return !is_null($service) && $service->delete() ? "success" : "Error: Object does not exist or you do not have the required permissions to delete it";
			

	}
	
	public function create(){
		
		return view('services.create');
	}
	
	public function edit($id){
		$rows = Service::Where('id', $id )
		->where('user_id', $this->userID )
		->firstOrFail();
		
		return view('services.edit')->with('rows',$rows);
	}
	
	public function update($id, Requests\CreateServiceRequest $request){
		$service = Service::Where('id', $id )
		->where('user_id', $this->userID )
		->firstOrFail();

		$service->update($request->all());
		
		return $service->toJson();
	}
	
	public function store(Requests\CreateServiceRequest $request){

		$service = new Service($request->all());
		$service->user_id = $this->userID;
		
		$service->save();
		
		return $service->toJson();
	}
}