<?php
use Illuminate\\Database\\Migrations\\Migration;use Illuminate\\Database\\Schema\\Blueprint;use Illuminate\\Support\\Facades\\Schema;
return new class extends Migration{public function up():void{Schema::create('service_clock',function(Blueprint $t){$t->unsignedTinyInteger('id')->primary();$t->timestampTz('now');});}public function down():void{Schema::dropIfExists('service_clock');}};