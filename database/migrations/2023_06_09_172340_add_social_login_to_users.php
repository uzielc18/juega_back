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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('facebook_id')->nullable();
            $table->string('linkedin_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('social_id')->nullable();
            $table->string('social_type')->nullable();
            $table->string('usuario_temporal')->nullable();
            $table->string('access_token')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('social_id');
            $table->dropColumn('social_type');
            $table->dropColumn('facebook_id')->nullable();
            $table->dropColumn('linkedin_id')->nullable();
            $table->dropColumn('twitter_id')->nullable();
            $table->dropColumn('access_token')->nullable();
        });
    }
};
