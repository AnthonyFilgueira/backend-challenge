<?php
namespace App\Http\Controllers;use App\Http\Requests\SetClockRequest;use Illuminate\Http\Response;use Illuminate\Support\Facades\DB;
class TestClockController{public function set(SetClockRequest $r):Response{if(env('CLOCK_MODE')!=='test')abort(404);DB::table('service_clock')->updateOrInsert(['id'=>1],['now'=>$r->validated('now')]);return response()->noContent();}}