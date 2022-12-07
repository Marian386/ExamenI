<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwitterDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitter_data', function (Blueprint $table) {
            $table->id();
            $table->longText('user_access_token')->nullable();
            $table->longText('twitter_oauth_token_secret')->nullable();
            $table->string('user_id')->nullable();
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
        Schema::dropIfExists('twitter_data');
    }
}
