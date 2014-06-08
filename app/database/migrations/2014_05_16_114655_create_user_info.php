<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_info', function(Blueprint $table)
		{
			$table->increments('user_id')->unsigned();
            $table->string('user_name',64);
            $table->string('user_email',64);
            $table->string('user_pass',32);
            $table->smallInteger('user_status')->unsigned()->default(UserEnum::USER_STATUS_AWAITING_ACTIVATE);
            $table->integer('account_id')->unsigned();
            $table->string('user_ticket',32)->default(null);
            $table->string('user_mobile',16);
            $table->smallInteger('mobile_auth')->unsigned()->default(UserEnum::USER_MOBILE_AUTH_NO);
            $table->string('user_qq',15)->unllable();
            $table->smallInteger('user_from')->unsigned()->default(UserEnum::USER_FROM_TSB);
            $table->integer('activating_time')->default(0);//激活时间
            $table->integer('login_time')->default(0);
            $table->integer('last_login_time')->default(0);
            $table->index('user_email','index_email');
            $table->index('user_mobile','index_mobile');
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
        Schema::dropIfExists('user_info');
	}

}
