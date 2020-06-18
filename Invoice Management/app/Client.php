<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';
	public $timestamps = false;
    protected $fillable = ['companyName', 'clientName', 'email', 'phone'];
	protected $visible = ['id','companyName', 'clientName', 'email', 'phone', 'address'];
	
	
	public function address()
    {
        return $this->hasOne('App\Address');
    }
	
	public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }
}
