<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('version')->nullable();
            $table->string('package')->default('basic');
            $table->string('status')->default('inactive');
            $table->integer('cache_age')->default(3);
            $table->timestamp('cache_expires')->default(now()->addDays(3));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('software_info');
    }
}
