<?php
use Illuminate\\Support\\Facades\\Route;
use Illuminate\\Support\\Facades\\DB;
use App\\Http\\Controllers\\ClinicController;
use App\\Http\\Controllers\\PatientController;
use App\\Http\\Controllers\\AppointmentController;
Route::get('/health',function(){DB::connection()->getPdo();return response()->json(['ok'=>true]);});
Route::post('/clinics',[ClinicController::class,'store']);
Route::post('/patients',[PatientController::class,'store']);
Route::post('/appointments',[AppointmentController::class,'store']);
Route::get('/appointments/{id}',[AppointmentController::class,'show']);
Route::patch('/appointments/{id}',[AppointmentController::class,'reschedule']);
Route::post('/appointments/{id}/cancel',[AppointmentController::class,'cancel']);
