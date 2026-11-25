<?php
namespace App\\Repositories;use App\\Models\\Reminder;
class ReminderRepository{public function create(array $d):Reminder{return Reminder::create($d);}public function cancelPending(string $appointmentId):int{return Reminder::where('appointment_id',$appointmentId)->where('status','pending')->update(['status'=>'cancelled']);}}