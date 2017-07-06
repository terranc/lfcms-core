<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_posts', function (Blueprint $table) {
            $table->unsignedInteger('post_id')->default('0');
            $table->text('content')->nullable();
            $table->timestamp('top_at')->nullable()->default(null)->comment('置顶时间,NULL时表示非置顶');
            $table->timestamps();

            $table->primary('post_id');
            $table->foreign('post_id')->references('id')->on('documents')
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
        Schema::table('document_posts', function (Blueprint $table){
            $table->dropForeign('document_posts_post_id_foreign');
        });
        Schema::dropIfExists('document_posts');
    }
}
