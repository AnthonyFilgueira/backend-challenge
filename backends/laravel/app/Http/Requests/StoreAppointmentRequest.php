<?php
namespace App\\Http\\Requests;use Illuminate\\Foundation\\Http\\FormRequest;
class StoreAppointmentRequest extends FormRequest{public function authorize():bool{return true;}public function rules():array{return ['clinicId'=>['required','uuid'],'patientId'=>['required','uuid'],'startsAt'=>['required','date']];}}