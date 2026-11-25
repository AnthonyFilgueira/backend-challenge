<?php
namespace App\\Models;use Illuminate\\Database\\Eloquent\\Model;
class Clinic extends Model{protected $fillable=['name','timezone'];public $timestamps=false;public function patients(){return $this->hasMany(Patient::class);}public function appointments(){return $this->hasMany(Appointment::class);}}