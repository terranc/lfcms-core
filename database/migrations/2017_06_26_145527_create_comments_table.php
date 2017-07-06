<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->default('0')->comment('被回复的评论');
            $table->unsignedInteger('user_id')->default('0')->comment('发表评论的用户Id');
            $table->unsignedInteger('to_user_id')->default('0')->comment('被评论的用户Id');
            $table->string("commentable_type")->nullable()->comment('评论对象类型');
            $table->unsignedInteger("commentable_id")->nullable()->default('0')->comment('评论对象Id');
            $table->tinyInteger('status')->default('0')->comment('状态；0：未审核；1：已审核');
            $table->text('content')->nullable()->default(null)->comment('评论内容');
            $table->timestamp('top_at')->nullable()->default(null)->comment('置顶时间');
            $table->json('meta')->nullable()->default(null)->comment('扩展属性');
            $table->softDeletes();
            $table->timestamps();

            $table->index(["commentable_id", "commentable_type"]);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
