<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->enum('type', ['admin', 'user'])->default('user')->comment('用户类型');
            $table->string('username', 150)->unique()->nullable()->default(null)->comment('用户名');
            $table->string('nickname', 50)->nullable()->default(null)->comment('昵称');
            $table->string('email', 150)->nullable()->default(null)->comment('邮箱');
            $table->char('mobile', 14)->nullable()->default(null)->comment('手机号码');
            $table->char('password', 60)->default('')->comment('密码');
            $table->string('avatar', 255)->default('')->comment('头像地址');
            $table->tinyInteger('status')->default('0')->comment('状态；0：禁用；1：启用');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
