<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_datas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->enum('gender', ['男', '女'])->nullable()->default(null)->comment('性别；null：保密；');
            $table->string('description', 255)->nullable()->comment('介绍');
            $table->date('birthday')->nullable()->comment('生日');
            $table->unsignedInteger('score')->default('0')->comment('积分');
            $table->unsignedInteger('coin')->default('0')->comment('金币');
            $table->timestamp('last_login_at')->nullable()->comment('最后登录时间');
            $table->unsignedInteger('last_login_ip')->nullable()->default(null)->comment('最后登录IP，long2ip转化');
            $table->json('meta')->nullable()->comment('扩展信息，json 对象');
            $table->timestamps();

            $table->primary('user_id');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::table('user_datas', function (Blueprint $table){
            $table->dropForeign('user_datas_user_id_foreign');
        });
        Schema::dropIfExists('user_datas');
    }
}
