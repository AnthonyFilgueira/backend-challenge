<?php
namespace App\\Repositories;use App\\Models\\Appointment;
class AppointmentRepository{public function create(array $d):Appointment{return Appointment::create($d);}public function find(string $id):?Appointment{return Appointment::with('reminders')->find($id);}public function lock(string $id):?Appointment{return Appointment::whereKey($id)->lockForUpdate()->first();}}