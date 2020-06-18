<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
	public $timestamps = true;
	protected $visible = [ 'id', 'invoiceNumber',  'sentEmail', 'dateDue', 'created_at', 'total', 'unitNumber', 'street', 'city', 'province',
	'postalCode', 'companyName', 'clientName', 'email', 'phone'];
	protected $fillable = ['invoiceNumber', 'dueDate', 'sentEmail'];
	protected $dates = ['dueDate', 'sentEmail', 'created_at', 'paidDate'];
	
	 /**
     * Get the line items for the invoice.
     */
    public function invoiceLineItems()
    {
        return $this->hasMany('App\InvoiceLineItem'); 
    }
	
	
}
