<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_models', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name', 12)->nullable()->default(null)->comment('标识');
            $table->string('title', 50)->nullable()->default(null)->comment('模块名称');
            $table->string('list_tpl', 50)->nullable()->default(null)->comment('列表模板（后台）');
            $table->string('add_tpl', 50)->nullable()->default(null)->comment('添加模板（后台）');
            $table->string('edit_tpl', 50)->nullable()->default(null)->comment('编辑模板（后台）');
            $table->unsignedInteger('page_size')->default('15')->comment('每页显示数量（后台）');
            $table->tinyInteger('status')->default('0')->comment('状态');
            $table->json('meta')->nullable()->default(null)->comment('扩展配置');
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
        Schema::dropIfExists('document_models');
    }
}
