<?php
namespace App\Http\Controllers;use App\Http\Requests\StoreClinicRequest;use App\Services\ClinicService;use Illuminate\Http\JsonResponse;
class ClinicController{public function __construct(private ClinicService $service){}public function store(StoreClinicRequest $r):JsonResponse{return response()->json($this->service->create($r->validated()),201);}}