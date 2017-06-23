<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaggablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taggables', function (Blueprint $table) {
            $table->engine = 'InnoDB';
//            $table->increments('id');
            $table->unsignedInteger('tag_id')->default('0')->comment('tag Id');
            $table->unsignedInteger('taggable_id')->default('0')->comment('内容 Id');
            $table->char('taggable_type', 20)->nullable()->comment('数据类型');
            $table->primary(['taggable_type', 'taggable_id', 'tag_id']);
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taggables');
    }
}
