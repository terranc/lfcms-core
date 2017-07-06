<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['link', 'page', 'list'])->default('list')->comment('类型');
            $table->char('flag', 20)->unique()->comment('类别标识');
            $table->string('title', 100)->comment('类别标题');
            $table->string('description', 255)->comment('类别描述');
            $table->char('path', 20)->comment('类表路径');
            $table->string('thumb', 255)->nullable()->default(null)->comment('缩略图');
            $table->unsignedTinyInteger('status')->default('0')->comment('状态；0：未启用；1：已启用');
            $table->unsignedInteger('sort_id')->default('1000')->comment('排序');
            $table->tinyInteger('is_display')->default('0')->comment('前台是否显示');
            $table->tinyInteger('is_comment')->default('0')->comment('是否允许评论');
            $table->tinyInteger('is_check')->default('0')->comment('是否需要审核');
            $table->unsignedTinyInteger('is_system')->default('0')->comment('是否系统类别，不能删除');
            $table->string('list_tpl', 50)->nullable()->default(null)->comment('列表模板');
            $table->string('show_tpl', 50)->nullable()->default(null)->comment('详情模板');
            $table->json('meta')->nullable()->comment('更多配置JSON');
            $table->softDeletes();
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
        Schema::dropIfExists('categories');
    }
}
