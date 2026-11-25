<?php
namespace App\Services;use App\Repositories\ClinicRepository;use Illuminate\Support\Str;
class ClinicService{public function __construct(private ClinicRepository $repo){}public function create(array $d):array{$c=$this->repo->create(['id'=>(string)Str::uuid(),'name'=>$d['name'],'timezone'=>$d['timezone']]);return ['id'=>$c->id,'name'=>$c->name,'timezone'=>$c->timezone];}}