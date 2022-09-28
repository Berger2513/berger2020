<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAdminUrlPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_url_page', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('url');
        });

        Schema::table('admin_url_page', function (Blueprint $table) {
            $table->string('home_url');
            $table->string('activity_url');
            $table->string('category_url');
            $table->string('community_url');
            $table->string('shop_url');
            $table->string('concat_url');
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
