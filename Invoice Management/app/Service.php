<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	protected $table = 'service';
	public $timestamps = false;
    protected $fillable = ['name', 'shortDescription', 'flatRate', 'hourlyRate',
	'longDescription'];
	protected $visible = ['id', 'name', 'shortDescription','flatRate', 'hourlyRate'];
	
	/**
     * Get the user for the service.
     */
    public function user()
    {
        return $this->belongsTo('App\User'); 
    }
	
	public function isTheOwner($user)
	{
		return $this->user_id === $user->id;
	}

}
