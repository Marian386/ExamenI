<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialpostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialposts', function (Blueprint $table) {
            $table->id();
            $table->string('social_auth_id')->nullable();
            $table->string("user_id")->nullable();
            $table->string('redsocial')->nullable();
            $table->string('comment')->nullable();
            $table->string('hour')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('socialposts');
    }
}
