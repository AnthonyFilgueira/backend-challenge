<?php
namespace App\Repositories;use App\Models\Patient;
class PatientRepository{public function create(array $data):Patient{return Patient::create($data);}public function find(string $id):?Patient{return Patient::find($id);}}