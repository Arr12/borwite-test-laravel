<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Travel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('letter_date');
            $table->string('destination');
            $table->string('reason_to_travel');
            $table->datetime('date_start');
            $table->datetime('date_end');
            $table->string('approval_status');
            $table->string('cash_advance_status');
            $table->timestamps();
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel');
    }
}
