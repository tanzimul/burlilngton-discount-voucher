<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_programs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('membership_id');
            $table->string('membership_type','10');
            $table->integer('discount_id');
            $table->string('device','20')->nullable();
            $table->smallInteger('print_count');
            $table->boolean('is_used');
            $table->boolean('is_admin');
            $table->dateTime('used_at', 0)->nullable();
            $table->timestamps();

            $table->foreign('membership_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_programs');
    }
}
