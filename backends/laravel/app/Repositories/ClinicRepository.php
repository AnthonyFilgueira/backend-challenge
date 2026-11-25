<?php
namespace App\Repositories;use App\Models\Clinic;
class ClinicRepository{public function create(array $data):Clinic{return Clinic::create($data);}public function find(string $id):?Clinic{return Clinic::find($id);}}