<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('account_info', function(Blueprint $table)
        {
            $table->increments('account_id')->unsigned();
            $table->integer('package_id')->unsigned();
            $table->smallInteger('account_status')->unsigned()->default(UserEnum::STATUS_NORMAL);
            $table->integer('create_time')->unsigned();
            $table->smallInteger('currency_type')->unsigned()->default(CurrencyEnum::RENMINBIN);
            $table->integer('balance_value')->unsigned()->default(0);
            $table->integer('recharge_time')->unsigned()->default(0);//余额变更时间
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
        Schema::dropIfExists('account_info');
	}

}
