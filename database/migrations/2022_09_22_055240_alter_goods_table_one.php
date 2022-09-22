<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGoodsTableOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn('view_nums');
            $table->dropColumn('collection_nums');
        });

        Schema::table('goods', function (Blueprint $table) {
            $table->integer('view_nums')->default(1);
            $table->integer('collection_nums')->default(1);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
