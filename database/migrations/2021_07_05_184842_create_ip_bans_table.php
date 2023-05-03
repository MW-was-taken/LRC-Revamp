<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_bans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('banner_id')->unsigned()->nullable();
            $table->bigInteger('unbanner_id')->unsigned()->nullable();
            $table->ipAddress('ip');
            $table->timestamps();

            $table->foreign('banner_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('unbanner_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip_bans');
    }
}
