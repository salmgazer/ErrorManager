<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulkFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename', 255);
            $table->integer('user_id');
            $table->enum('status', array('processed', 'new'));
            $table->string('operation', 255)
            $table->double('success_rate');
            $table->enum('action', array('RETRY', 'FC', 'FAILED'));
            $table->enum('by_id', array('yes', 'no'));
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
        Schema::drop('bulk_files');
    }
}
