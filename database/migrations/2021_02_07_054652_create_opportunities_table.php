<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('account_id');
            $table->string('sales_stage');
            $table->float('amount', 8, 2);
            $table->string('type')->nullable();
            $table->integer('reward_percentage');
            $table->float('reward_amount',8,2);
            $table->timestamp('referral_start_date')->useCurrent();
            $table->integer('created_by');
            $table->date('sale_start')->nullable();
            $table->date('sale_end')->nullable();
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
        Schema::dropIfExists('opportunities');
    }
}
