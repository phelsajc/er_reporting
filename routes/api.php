<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('addEmployee', 'AuthController@refresh');
    
});



Route::match(['get','post'],'getSDtations','CensusController@getSDtations');
Route::match(['get','post'],'getCensus','CensusController@index');


Route::get('pdf','PDFController@pdf');
Route::apiResource('/employee','Api\EmployeeController');


Route::match(['get','post'],'/filterEmployee','Api\EmployeeController@filterEmployee');
Route::match(['get','post'],'/patientEmployee','Api\PatientController@filterEmployee');
//Route::match(['get','post'],'/patientEmployee','Api\PatientController@filterEmployee_test');
Route::match(['get','post'],'/check_doctors_detail/{id}','Api\PatientController@check_doctors_detail');

Route::match(['get','post'],'saveInitialData','Api\PatientController@saveInitialData');
Route::match(['get','post'],'searchMedicine','MedicineController@searchMedicine');
Route::match(['get','post'],'searchDiagnostic','MedicineController@searchDiagnostic');
Route::match(['get','post'],'getPxInfo/{pspat}','Api\PatientController@getPxInfo');
Route::match(['get','post'],'getFormDetail/{id}','Api\PatientController@EditInitialData');
Route::match(['get','post'],'upDateHPE','Api\PatientController@upDateHPE');
Route::match(['get','post'],'getDiagnosisInfo/{pspat}','Api\PatientController@getDiagnosisInfo');
Route::match(['get','post'],'addMedicine/{method}/{pspat}/{diagnosis_id}','PrescriptionController@store');
Route::match(['get','post'],'getrequency','PrescriptionController@getrequency');
Route::match(['get','post'],'getPrescribeMedicine/{id}','PrescriptionController@getPrescribeMedicine');
Route::match(['get','post'],'getPrecriptionDetail/{id}','PrescriptionController@getPrecriptionDetail');
Route::match(['get','post'],'updateMedicine/{method}/{diagnosis_id}','PrescriptionController@updateMedicine');
Route::match(['get','post'],'addDiagnostics','PrescriptionController@addDiagnostics');
Route::match(['get','post'],'print_prescription/{id}/{doctor}','PDFController@printPrescription');
Route::match(['get','post'],'getPrescribeLabs/{id}','PrescriptionController@getPrescribeLabs');
Route::match(['get','post'],'destroyLab/{id}','PrescriptionController@destroyLab');
Route::match(['get','post'],'destroyMeds/{id}','PrescriptionController@destroyMeds');


Route::get('update-peds/{id}/{pspat}', 'PrescriptionController@transfer_peds');   

Route::match(['get','post'],'addusers','UserController@registerUser');
Route::match(['get','post'],'listusers','UserController@getAllUsers');
Route::match(['get','post'],'getUser/{id}','UserController@getUser');

Route::match(['get','post'],'show_frequency/{id}','PrescriptionController@show_frequency');
Route::match(['get','post'],'printChart/{pid}','PrescriptionController@printChart');



//Route::get('/print_prescription/{id}/{doctor}', 'Prescription@printPrescription');












