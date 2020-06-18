<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);

Route::get('/', 'HomeController@index');
Route::get('/home','HomeController@index');

Route::get('services/{id}/destroy', 'ServicesController@destroy');

Route::resource('services', 'ServicesController');

Route::get('clients/{id}/destroy', 'ClientController@destroy');
Route::get('clients/showPlain', 'ClientController@showPlain');

Route::resource('clients', 'ClientController');

Route::get('invoices/{id}/delete', 'InvoiceController@delete');
Route::get('invoices/dateSearch', 'InvoiceController@dateSearch');
Route::get('invoices/serviceList', 'InvoiceController@serviceList');
Route::get('invoices/clientList', 'InvoiceController@clientList');
Route::get('invoices/sendEmail', 'InvoiceController@sendEmail');
Route::get('invoices/{id}/payInvoice', 'InvoiceController@payInvoice');



Route::resource('invoices', 'InvoiceController');

Route::get('reports/', 'ReportController@index');
Route::get('reports/client', 'ReportController@client');
Route::get('reports/annually', 'ReportController@annually');
Route::get('reports/monthly', 'ReportController@monthly');
Route::get('reports/getInvoiceClients', 'ReportController@getInvoiceClients');
Route::get('reports/showClient', 'ReportController@showClient');

Route::get('help/', 'HelpController@index');


