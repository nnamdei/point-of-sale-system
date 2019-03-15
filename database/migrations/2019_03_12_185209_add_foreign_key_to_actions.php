<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->unsignedInteger('product_id', 10)->change();
            $table->index('product_id');
            $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->onDelete('cascade');

            $table->unsignedInteger('user_id', 10)->change();
            $table->index('user_id');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::table('actions', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropForeign(['product_id']);

            $table->dropIndex(['user_id']);
            $table->dropForeign(['user_id']);
        });
    }
}
