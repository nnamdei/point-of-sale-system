<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('staff_id');
            $table->foreign('staff_id')
                    ->references('id')
                    ->on('staff')
                    ->onDelete('cascade');

            $table->index('admin_id');
            $table->foreign('admin_id')
                    ->references('id')
                    ->on('admins')
                    ->onDelete('cascade');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
            $table->dropIndex(['staff_id']);

            $table->dropForeign(['admin_id']);
            $table->dropIndex(['admin_id']);


        });
    }
}
