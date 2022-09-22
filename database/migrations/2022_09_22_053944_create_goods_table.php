<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->bigIncrements('goods_id');
            $table->bigInteger('category_id');
            $table->string('name')->comment('名称');
            $table->string('taobao_id')->comment('淘宝id');
            $table->string('cover')->comment('封面');
            $table->string('description')->comment('描述');
            $table->text('content')->comment('内容');
            $table->string('options')->comment('规格');
            $table->integer('view_nums')->comment('浏览量');
            $table->string('collection_nums')->comment('收藏量');
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
        Schema::dropIfExists('goods');
    }
}
