<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecycleBinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recycle_bin', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('table_name', 20)->nullable()->comment('删除内容所在表');
            $table->unsignedInteger('object_id')->default('0')->comment('删除内容ID');
            $table->string('name', 255)->nullable()->comment('删除内容标题/名称');
            $table->timestamp('created_at')->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recycle_bin');
    }
}
