<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variants', function (Blueprint $table) {
            $table->unsignedInteger('product_id', 10)->change();
            $table->index('product_id');
            $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
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
        Schema::table('variants', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropForeign(['product_id']);
        });
    }
}
