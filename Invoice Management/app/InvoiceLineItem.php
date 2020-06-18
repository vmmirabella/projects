<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceLineItem extends Model
{
    
	protected $table = 'invoiceLineItem';
	public $timestamps = false;
	protected $visible = ['id', 'invoice_id', 'totalHours', 'totalPrice', 'name', 'shortDescription', 'flatRate', 'hourlyRate', 'longDescription'];
	protected $fillable = ['totalHours', 'name', 'shortDescription', 'flatRate', 'hourlyRate', 'longDescription']; 
	
    /**
     * Get the invoice that owns the line item.
     */
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
	
}
