<?php
use Illuminate\Support\Facades\Route;use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ClinicController;use App\Http\Controllers\PatientController;use App\Http\Controllers\AppointmentController;use App\Http\Controllers\WebhookController;use App\Http\Controllers\ReminderJobController;use App\Http\Controllers\TestClockController;
Route::get('/health',function(){DB::connection()->getPdo();return response()->json(['ok'=>true]);});
Route::post('/clinics',[ClinicController::class,'store']);Route::post('/patients',[PatientController::class,'store']);
Route::post('/appointments',[AppointmentController::class,'store']);Route::get('/appointments/{id}',[AppointmentController::class,'show']);Route::patch('/appointments/{id}',[AppointmentController::class,'reschedule']);Route::post('/appointments/{id}/cancel',[AppointmentController::class,'cancel']);
Route::post('/jobs/reminders/run',[ReminderJobController::class,'run']);Route::post('/webhooks/inbound-messages',[WebhookController::class,'inbound']);Route::put('/test/clock',[TestClockController::class,'set']);