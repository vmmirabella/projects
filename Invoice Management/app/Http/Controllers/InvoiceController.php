<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Invoice;
use App\InvoiceLineItem;
use App\Service;
use App\Client;
use App\Address;
use DateTime;
use Carbon\Carbon;
use DB;
use Auth;
use Mail;
use DateInterval;

class InvoiceController extends Controller
{
	
	private $resultsPerPage;
	private $carbon_dateFormat;
	
	
	public function __construct() {
		$this->middleware('auth');
		$this->resultsPerPage = env('RESULTS_PER_PAGE');
		
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
    public function index(Request $request)
    {
        $rows = $this->search($request);
		$rows->appends(['search' => $request->input('search', '')]);

		return view('invoices.search')->with('rows',$rows);
    }
	
	private function search(Request $request){
		$startDate = $request->input('startDate');
		$endDate = $request->input('endDate');
		
		$from = DateTime::createFromFormat($this->carbon_dateFormat , $startDate);
		$to = DateTime::createFromFormat($this->carbon_dateFormat , $endDate);
		$search = '%'.$request->input('search', '').'%';
		
		$rows = Invoice::where('user_id', $this->userID );
		
		if($from && $to){
			$from->sub(new DateInterval('P1D'));
			$to->add(new DateInterval('P1D'));
			
			$rows = $rows->where(function ($query) use ($from, $to){
						$query->whereBetween('created_at', [$from, $to])
						->orWhereBetween('dueDate', [$from, $to])
						->orWhereBetween('sentEmail', [$from, $to]);
					});
		}
		
		$rows = $rows->where(function ($query) use($search) {
					$query->where('clientName', 'LIKE', $search )
					->orWhere('invoiceNumber', 'LIKE', $search );
				})
			->orderBy('paidDate', 'ASC')
			->orderBy('created_at', 'ASC')
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
        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateInvoiceRequest $request)
    {
		$clientID = $request->input('client_id');
		
		$client = Client::With('address')->where('id', $clientID)
		->where('user_id', $this->userID)
		->firstOrFail();
		
		$subtotal = 0;
		$items = Array();
		
        foreach($request->get('invoiceLineItems') as $val) {
			$lineItem = new InvoiceLineItem([
				'name' => $val['name'],
				'shortDescription' => $val['shortDescription'],
				'flatRate' => $val['flatRate'],
				'hourlyRate' => $val['hourlyRate'],
				'longDescription' => $val['longDescription'],
				'totalHours' => $val['totalHours']
			]);
			
			$lineItem->totalPrice = $lineItem->flatRate +
			($lineItem->hourlyRate*$lineItem->totalHours);
			
			$items[] = $lineItem;
			
			$subtotal += $lineItem->totalPrice;
			
		}

		$invoice = new Invoice();
		
		$dueDate = DateTime::createFromFormat($this->carbon_dateFormat , $request->input('dueDate'));
		$created_at = Carbon::now();
		
		//client
		$invoice->companyName = $client->companyName;
		$invoice->clientName = $client->clientName;
		$invoice->user_id = $client->user_id;
		$invoice->email = $client->email;
		$invoice->phone = $client->phone;
		
		//address
		$invoice->unitNumber = $client->address->unitNumber;
		$invoice->street = $client->address->street;
		$invoice->city = $client->address->city;
		$invoice->province = $client->address->province;
		$invoice->postalCode = $client->address->postalCode;
		
		//invoice
		$invoice->invoiceNumber = $request->input('invoiceNumber');
		$invoice->taxRate = $request->input('taxRate');
		$invoice->dueDate = $dueDate;
		$invoice->created_at = $created_at;
		$invoice->sentEmail = null;
		$invoice->subTotal = $subtotal;
		$invoice->total = $subtotal * (1 + ($request->input('taxRate')/100.00));
		
		
		
		DB::transaction(function() use ($invoice, $items) {
			
			InvoiceLineItem::where('invoice_id',$invoice->id)->delete();
			
			$invoice->save();
			
			for( $i = 0; $i < count($items); $i++){
				$items[$i]->invoice_id = $invoice->id;
				$items[$i]->save();
			}
			
		});
		
		$sentEmail = null;
		
		if($invoice->sentEmail)
			$sentEmail = $invoice->sentEmail->format($this->carbon_dateFormat);
		else
			$sentEmail = "";
		
		$json = Array(
			'id' => $invoice->id,
			'invoiceNumber' => $invoice->invoiceNumber,
			'clientName' => $invoice->clientName,
			'created_at' => $invoice->created_at->format($this->carbon_dateFormat),
			'dueDate' => $invoice->dueDate->format($this->carbon_dateFormat),
			'sentEmail' => $sentEmail,
			'paidDate' => ""
		);
		

		return json_encode($json);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {	
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

		return view('invoices.view')->with('rows',$rows);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

		return view('invoices.edit')->with('rows',$rows);
    }
	
	
	
	/**
     * Provides JSON for the Edit form's Service list autocomplete
     *
     * 
     * @return JSON
     */
	public function serviceList(Request $request){
		$q = $request->input('term', '');
		
		$service = Service::where('name', 'LIKE', '%'.$q.'%' )
		->where('user_id', $this->userID)
		->get();

		$json = Array();
		
		foreach($service as $item){
			$json[] = [ 'value' => $item->name, 'id' => $item->id, 'label' => $item->name,
			'flatRate' => $item->flatRate, 'hourlyRate' => $item->hourlyRate, 'shortDescription' => $item->shortDescription, 'longDescription' => $item->longDescription ];
			
		}

		return json_encode($json);
	}
	
	/**
     * Provides JSON for the Edit form's Service list autocomplete
     *
     * 
     * @return JSON
     */
	public function clientList(Request $request){
		$search = $request->input('term', '');
		
		$client = Client::Where('user_id', $this->userID)
		->where(function($query) use($search) {
					$query->where('clientName', 'LIKE', '%'.$search.'%' )
					->orWhere('companyName', 'LIKE', '%'.$search.'%' );
				})->get();

		$json = Array();
		
		foreach($client as $item){
			$label = $item->companyName.' - '.$item->clientName;
			
			$json[] = [ 'value' => $label, 'id' => $item->id, 'label' => $label];
			
		}

		return json_encode($json);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Requests\CreateInvoiceRequest $request)
    {
		
		$invoice = Invoice::with('invoiceLineItems')
		->where('id', $id)
		->where('user_id', $this->userID )
		->firstOrFail();
		
		$subtotal = 0;
		$items = Array();
		
        foreach($request->get('invoiceLineItems') as $val) {
			
			$lineItem = new InvoiceLineItem([
				'name' => $val['name'],
				'shortDescription' => $val['shortDescription'],
				'flatRate' => $val['flatRate'],
				'hourlyRate' => $val['hourlyRate'],
				'longDescription' => $val['longDescription'],
				'totalHours' => $val['totalHours']
			]);
			
			$lineItem->totalPrice = $lineItem->flatRate +
			($lineItem->hourlyRate*$lineItem->totalHours);
			
			$items[] = $lineItem;
			
			$subtotal += $lineItem->totalPrice;
			

		}

		$dueDate = DateTime::createFromFormat($this->carbon_dateFormat , $request->input('dueDate'));
		$created_at = DateTime::createFromFormat($this->carbon_dateFormat , $request->input('created_at'));
		
		$clientID = $request->input('client_id');
		
		if($clientID) {
			$client = Client::With('address')->where('id', $clientID)
			->where('user_id', $this->userID)
			->firstOrFail();
			
			//client
			$invoice->companyName = $client->companyName;
			$invoice->clientName = $client->clientName;
			$invoice->user_id = $client->user_id;
			$invoice->email = $client->email;
			$invoice->phone = $client->phone;
			
			//address
			$invoice->unitNumber = $client->address->unitNumber;
			$invoice->street = $client->address->street;
			$invoice->city = $client->address->city;
			$invoice->province = $client->address->province;
			$invoice->postalCode = $client->address->postalCode;
		}
		
		
		
		//invoice
		$invoice->taxRate = $request->input('taxRate');
		$invoice->dueDate = $dueDate;
		$invoice->subTotal = $subtotal;
		$invoice->total = $subtotal * (1 + ($request->input('taxRate')/100.00));
		
		
		
		DB::transaction(function() use ($invoice, $items) {
			
			InvoiceLineItem::where('invoice_id',$invoice->id)->delete();
			
			$invoice->push();
			
			for( $i = 0; $i < count($items); $i++){
				$items[$i]->invoice_id = $invoice->id;
				$items[$i]->save();
			}
			
		});
		
		$invoice = Invoice::with('invoiceLineItems')->findOrFail($id);
		$sentEmail = null;
		
		if($invoice->sentEmail)
			$sentEmail = $invoice->sentEmail->format($this->carbon_dateFormat);
		else
			$sentEmail = "";
		
		$json = Array(
			'id' => $invoice->id,
			'invoiceNumber' => $invoice->invoiceNumber,
			'clientName' => $invoice->clientName,
			'created_at' => $invoice->created_at->format($this->carbon_dateFormat),
			'dueDate' => $invoice->dueDate->format($this->carbon_dateFormat),
			'sentEmail' => $sentEmail,
			'paidDate' => ""
		);
		

		return json_encode($json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $errorMsg = "Error: Object does not exist or you do not have the required permissions to delete it";
        $invoice = Invoice::Where('id', $id)
		->where('user_id', $this->userID )
		->firstOrFail();
		
		if(is_null($invoice))
			return $errorMsg;
		
		InvoiceLineItem::where('invoice_id', $invoice->id)->delete();
		$invoice->delete();
		
		return "success";
    }
	
	public function payInvoice($id)
    {
        $errorMsg = "Error: Object does not exist or you do not have the required permissions";
        $invoice = Invoice::Where('id', $id)
		->where('user_id', $this->userID )
		->firstOrFail();
		
		if(is_null($invoice))
			return json_encode(['status' => $errorMsg, 'paidDate' => null]);
		
		$invoice->paidDate = Carbon::now();
		$invoice->push();
		
		return json_encode(['status' => 'success', 
		'paidDate' => $invoice->paidDate->format($this->carbon_dateFormat)]);
    }
	
	public function sendEmail(Request $request){
		$id = $request->input('id');
		
		$invoice = Invoice::Where('id', $id)
		->whereNull('paidDate')
		->where('user_id', $this->userID )
		->firstOrFail();
		
		$address = $invoice->email;
		$status = 'success';
		
		if($status == 'success' ) {
			
			$invoice->sentEmail = Carbon::now();
			
			$invoice->push();

			Mail::send('invoices.email', ['invoice' => $invoice], function ($m) use ($invoice) {
				$m->from(env('MAIL_FROM'), env('MAIL_NAME'));

				$m->to($invoice->email, $invoice->clientName)->subject('Invoice #'.$invoice->invoiceNumber);
			});
					
		
			return json_encode(['sentEmail' => Carbon::now()->format($this->carbon_dateFormat.' e'), 'status' => 'success' ]);
		} else {
			return json_encode(['emailSent' => null, 'status' => 'error' ]);
		}

	}
	
	
}
