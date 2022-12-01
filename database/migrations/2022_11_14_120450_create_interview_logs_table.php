<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interview_id')->index();
            $table->unsignedBigInteger('admin_user_id')->index();
            $table->unsignedBigInteger('employee_user_id')->index();
            $table->timestamp('date_time');
            $table->tinyInteger('status')->default(1)->index()->comment('1 - Scheduled, 2 - Selected for Trail, 3 - Selected, 4 - Rejected after trail, 5 - Rejected in interview');
            $table->timestamps();
            $table->foreign('interview_id')->references('id')->on('interviews')->cascadeOnDelete();
            $table->foreign('admin_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('employee_user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_logs');
    }
}
