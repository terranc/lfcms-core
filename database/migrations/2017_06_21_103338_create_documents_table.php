<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->default('0')->comment('用户Id');
            $table->string('title', 150)->nullable()->default(null)->comment('标题');
            $table->string('filename', 50)->nullable()->default(null)->comment('标识，用于友好 URL');
            $table->unsignedInteger('category_id')->default('0')->comment('类别Id');
            $table->string('source', 255)->nullable()->default(null)->comment('来源');
            $table->string('summary', 255)->nullable()->default(null)->comment('摘要');
            $table->unsignedInteger('model_id')->default('0')->comment('内容模型Id');
            $table->json('position')->nullable()->default(null)->comment('推荐位');
            $table->string('link_url', 255)->nullable()->default(null)->comment('外链');
            $table->string('thumb', 255)->nullable()->default(null)->comment('缩略图');
            $table->tinyInteger('is_comment')->default('0')->comment('是否允许评论');
            $table->unsignedBigInteger('view_count')->default('0')->comment('浏览量');
            $table->unsignedInteger('comment_count')->default('0')->comment('评论量');
            $table->integer('sort_id')->default('0')->comment('排序Id');
            $table->tinyInteger('status')->default('0')->comment('状态');
            $table->timestamp('expired_at')->nullable()->default(null)->comment('有效期限，null 为不限');
            $table->timestamp('published_at')->nullable()->default(null)->comment('发布时间，null 为不限');
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
        Schema::dropIfExists('documents');
    }
}
