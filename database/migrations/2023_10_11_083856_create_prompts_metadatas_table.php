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
        // Schema::create('prompts_metadatas', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        //     $table->softDeletes();
        //     $table->string('request_source', 255)->nullable();
        //     $table->string('user_agent', 512)->nullable();
        //     $table->string('user_ip', 45)->nullable();
        //     $table->string('referer', 2083)->nullable();
        //     $table->json('location')->nullable();
        //     $table->json('user_agent_parsed')->nullable();
        //     $table->integer('response_time')->nullable();
        //     $table->string('external_id', 255)->nullable();
        //     $table->unsignedBigInteger('conversation_id')->nullable(false);
        //     $table->unsignedBigInteger('prompt_history_id')->nullable();
        //     $table->foreign('conversation_id')->references('id')->on('conversations');
        //     $table->foreign('prompt_history_id')->references('id')->on('prompt_histories');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prompts_metadatas');
    }
};
