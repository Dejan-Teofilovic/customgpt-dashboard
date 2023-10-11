<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->timestamps(0);
            $table->softDeletes();
            $table->string('name', 255)->nullable(false);
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('session_id', 255)->nullable(false);
            $table->foreign('session_id')->references('id')->on('sessions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations');
    }
};
