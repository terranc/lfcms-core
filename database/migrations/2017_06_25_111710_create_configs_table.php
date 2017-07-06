<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('name', 30)->default('')->comment('配置名称');
            $table->char('namespace', 15)->default('')->comment('配置命名空间');
            $table->enum('type', ['string', 'enum', 'array', 'json'])->nullable()->default('string')->comment('配置值类型');
            $table->string('value', 255)->nullable()->default(null)->comment('配置值');
            $table->string('remark', 255)->nullable()->default(null)->comment('配置介绍');

            $table->unique(['namespace', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
