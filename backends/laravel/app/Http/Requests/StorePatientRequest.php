<?php
namespace App\\Http\\Requests;use Illuminate\\Foundation\\Http\\FormRequest;
class StorePatientRequest extends FormRequest{public function authorize():bool{return true;}public function rules():array{return ['clinicId'=>['required','uuid'],'name'=>['required','string','min:1'],'phone'=>['nullable','regex:/^\\+[1-9]\\d{7,14}$/'],'acceptsReminders'=>['required','boolean']];}}