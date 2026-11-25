<?php
namespace App\\Http\\Controllers;use App\\Services\\ReminderDispatchService;use Illuminate\\Http\\JsonResponse;
class ReminderJobController{public function __construct(private ReminderDispatchService $service){}public function run():JsonResponse{return response()->json($this->service->run());}}