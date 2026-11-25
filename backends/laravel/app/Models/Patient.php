<?php
namespace App\Models;use Illuminate\Database\Eloquent\Model;
class Patient extends Model{protected $fillable=['clinic_id','name','phone','accepts_reminders'];public $timestamps=false;protected $casts=['accepts_reminders'=>'boolean'];public function clinic(){return $this->belongsTo(Clinic::class);}public function appointments(){return $this->hasMany(Appointment::class);}}