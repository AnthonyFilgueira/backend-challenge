<?php
namespace App\\Http\\Requests;use Illuminate\\Foundation\\Http\\FormRequest;
class SetClockRequest extends FormRequest{public function authorize():bool{return env('CLOCK_MODE')==='test';}public function rules():array{return ['now'=>['required','date']];}}