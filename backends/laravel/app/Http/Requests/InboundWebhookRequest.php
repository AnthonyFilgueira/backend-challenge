<?php
namespace App\\Http\\Requests;use Illuminate\\Foundation\\Http\\FormRequest;
class InboundWebhookRequest extends FormRequest{public function authorize():bool{return true;}public function rules():array{return ['messageId'=>['required','string'],'from'=>['required','regex:/^\\+[1-9]\\d{7,14}$/'],'text'=>['required','string'],'receivedAt'=>['required','date']];}}