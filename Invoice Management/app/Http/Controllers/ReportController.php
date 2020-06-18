<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Client;
use App\Address;
use DB;
use Auth;
use DateTime;
use DateInterval;

class ReportController extends Controller
{
	
	private $carbon_dateFormat;
	
	public function __construct() {
		$this->middleware('auth');
		
		if(Auth::user())
			$this->userID = Auth::user()->id;
		else
			$this->userID = -1;
		
		/* WARNING: You must ensure that the formats of the JQuery datepicker and Laravel's Carbon 
		 * are equivalent. They each use their own syntax.
		 * JQuery Datepicker: http://api.jqueryui.com/datepicker/#utility-formatDate
		 * Carbon PHP: http://php.net/manual/en/function.date.php
		 */
		 $this->carbon_dateFormat ='d/m/Y';
		
		view()->share('jquery_datepicker_dateFormat', 'dd/mm/yy');
		view()->share('carbon_dateFormat', $this->carbon_dateFormat );
		
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function annually(Request $request)
    {
		$startDate = $request->input('startDate');
		$endDate = $request->input('endDate');
		$outstandingInvoices = $request->input('invoiceType');
		
		$from = DateTime::createFromFormat($this->carbon_dateFormat , $startDate);
		$to = DateTime::createFromFormat($this->carbon_dateFormat , $endDate);
		
		
		$invoices = Invoice::select(DB::raw(' year(created_at) as y, month(created_at) as m, sum(total) as t'))
		->where('user_id', $this->userID );
		
		if($from && $to) {
			$from->sub(new DateInterval('P1D'));
			$to->add(new DateInterval('P1D'));
			$invoices = $invoices->whereBetween('created_at', [$from, $to]);
		}
		
		if($outstandingInvoices && $outstandingInvoices == 'paid')
			$invoices = $invoices->whereNotNull('paidDate');
		else
			$invoices = $invoices->whereNull('paidDate');
		

		$invoices = $invoices
		->groupBy(DB::raw('year(created_at)'))
		->get();
		
		
		
		//TODO: sum the earnings for each month
		//http://stackoverflow.com/questions/20974383/sql-query-to-sum-up-amounts-by-month-year
		
		$json = array();
		foreach($invoices as $item) {
			
			$d = $item->y.'-01-01 00:00:00';
			$json[] = array(
							0 => (string) $d,
							1 =>  floatval($item->t)
						);

		}

		return view('reports.annually')->with('json', json_encode($json));
		
		
    }
	

    public function monthly(Request $request)
    {
		$startDate = $request->input('startDate');
		$endDate = $request->input('endDate');
		$outstandingInvoices = $request->input('invoiceType');
		
		$from = DateTime::createFromFormat($this->carbon_dateFormat , $startDate);
		$to = DateTime::createFromFormat($this->carbon_dateFormat , $endDate);

		$invoices = Invoice::select(DB::raw(' year(created_at) as y, month(created_at) as m, sum(total) as t'))
		->where('user_id', $this->userID );
		
		if($from && $to) {
			$from->sub(new DateInterval('P1D'));
			$to->add(new DateInterval('P1D'));
			$invoices = $invoices->whereBetween('created_at', [$from, $to]);
		}
		
		if($outstandingInvoices && $outstandingInvoices == 'paid')
			$invoices = $invoices->whereNotNull('paidDate');
		else
			$invoices = $invoices->whereNull('paidDate');
		

		$invoices = $invoices->groupBy(DB::raw('year(created_at), month(created_at)'))
			->get();

		
		
		//TODO: sum the earnings for each month
		//http://stackoverflow.com/questions/20974383/sql-query-to-sum-up-amounts-by-month-year
		
		$json = array();
		foreach($invoices as $item) {
			
			$d = $item->y.'-'.sprintf('%02d', $item->m).'-01 00:00:00';
			$json[] = array(
							0 => (string) $d,
							1 =>  floatval($item->t)
						);

		}

		return view('reports.monthly')->with('json', json_encode($json));
    }
	
	public function showClient(Request $request)
    {
		$id = $request->input('id');
		
		
		$rows = Invoice::with('invoiceLineItems')
		->where('id', $id)
		->where('user_id', $this->userID )
		->firstOrFail();
		
		$rows->client = new Client([
		'companyName' => $rows->companyName,
		'clientName' => $rows->clientName,
		'email' => $rows->email,
		'phone' => $rows->phone
		]);
		
		$rows->client->address = new Address([
		'unitNumber' => $rows->unitNumber,
		'street' => $rows->street,
		'city' => $rows->city,
		'province' => $rows->province,
		'postalCode' => $rows->postalCode
		]);
		
		return view('clients.view')->with('rows',$rows->client)->with('hideModal', true);
	}
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function client(Request $request)
    {

		$clientName = $request->input('clientName');
		$companyName = $request->input('companyName');
		$outstandingInvoices = $request->input('invoiceType');
		
        if(!($clientName && $companyName))
			return view('reports.client');
		
		$startDate = $request->input('startDate');
		$endDate = $request->input('endDate');
		
		$from = DateTime::createFromFormat($this->carbon_dateFormat , $startDate);
		$to = DateTime::createFromFormat($this->carbon_dateFormat , $endDate);
		
		$invoices = Invoice::where('clientName', $clientName)
		->where('companyName', $companyName)
		->where('user_id', $this->userID);
		
		if($from && $to) {
			$from->sub(new DateInterval('P1D'));
			$to->add(new DateInterval('P1D'));
			$invoices = $invoices->whereBetween('created_at', [$from, $to]);				
		}

		if($outstandingInvoices && $outstandingInvoices == 'paid')
			$invoices = $invoices->whereNotNull('paidDate');
		else
			$invoices = $invoices->whereNull('paidDate');
		
		$invoices = $invoices->orderBy('created_at', 'desc')
					->get();
		
		$json = array();
		foreach($invoices as $item) {
			$d = $item->created_at->format('Y-m-d h:i:sA');
			$json[] = array(
							0 => (string) $d,
							1 =>  floatval($item->total)
						);

		}
		
		return json_encode($json);
    }
	
	public function getInvoiceClients(Request $request){
		$search = $request->input('term', '');
		
		$invoice = Invoice::Select('companyName', 'clientName', 'id')
		->where('user_id', $this->userID)
		->where(function($query) use($search) {
			$query->where('companyName', 'LIKE', '%'.$search.'%')
			->orWhere('clientName', 'LIKE', '%'.$search.'%' );
		})
		->groupBy('companyName')
		->groupBy('clientName')
		->get();
		
		$json = [];
		foreach($invoice as $item){
			$label = $item->companyName.' - '.$item->clientName;
			
			$json[] = [ 'value' => $label,
						'companyName' => $item->companyName,
						'clientName' => $item->clientName,
						'id' => $item->id,
						'label' => $label];
			
		}
		
		return json_encode($json);
	}

    
}
