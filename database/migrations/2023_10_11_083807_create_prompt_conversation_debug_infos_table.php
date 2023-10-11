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
        Schema::create('prompt_conversation_debug_infos', function (Blueprint $table) {
            $table->id();
            $table->json('messages')->nullable();
            $table->string('status', 100)->nullable(false)->default('success');
            $table->longText('error_message')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('prompt_histories_id')->nullable();
            $table->foreign('prompt_histories_id')->references('id')->on('prompt_histories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prompt_conversation_debug_infos');
    }
};
