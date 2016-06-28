<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('errors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('oc_id', 255)->unique();
            $table->enum('tried', array('yes', 'no'));
            $table->enum('status', array('success', 'failed'));
            $table->integer('user_id');
            $table->integer('bulk_id');
            $table->enum('operation' array('Resubmit', 'Force complete', 'Cancel'));
            $table->string('scenario', 255)->nullable();
            $table->enum('by_scenario', array('yes', 'no'));
            $table->string('action', 100);
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
        Schema::drop('errors');
    }
}
