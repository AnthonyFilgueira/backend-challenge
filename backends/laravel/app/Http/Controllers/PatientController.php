<?php
namespace App\\Http\\Controllers;use App\\Http\\Requests\\StorePatientRequest;use App\\Services\\PatientService;use Illuminate\\Http\\JsonResponse;
class PatientController{public function __construct(private PatientService $service){}public function store(StorePatientRequest $r):JsonResponse{return response()->json($this->service->create($r->validated()),201);}}