<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('month');
            $table->string('year');
            $table->string('name');
            $table->integer('transport');
            $table->integer('meal');
            $table->boolean('is_sunday');
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
        Schema::dropIfExists('overtime_groups');
    }
}
