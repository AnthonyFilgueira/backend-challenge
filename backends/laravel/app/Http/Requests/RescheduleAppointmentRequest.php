<?php
namespace App\Http\Requests;use Illuminate\Foundation\Http\FormRequest;
class RescheduleAppointmentRequest extends FormRequest{public function authorize():bool{return true;}public function rules():array{return ['startsAt'=>['required','date']];}}