<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('admin_info',function($table){
            $table->increments('admin_id')->unsigned();
            $table->string('admin_name',64);
            $table->string('admin_email',64);
            $table->string('admin_pass',32);
            $table->smallInteger('admin_status')->unsigned()->default(1);
            $table->smallInteger('admin_right')->unsigned();
            $table->integer('parent_manager')->unsigned()->default(0);
            $table->integer('create_time')->unsigned();
            $table->integer('login_time')->unsigned();
            $table->integer('last_login_time')->unsigned();
            $table->index('admin_email','index_email');
            $table->engine = 'InnoDB';
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
        Schema::dropIfExists('admin_info');
	}

}
