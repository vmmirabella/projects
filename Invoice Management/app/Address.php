<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
	public $timestamps = false;
    protected $fillable = ['unitNumber', 'street', 'city', 'province',
	'postalCode'];
	protected $visible = ['unitNumber', 'street', 'city', 'province',
	'postalCode'];
	
	public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
