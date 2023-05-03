<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('receiver_id')->unsigned();
            $table->bigInteger('sender_id')->unsigned();
            $table->string('status')->default('pending'); // pending, declined, accepted
            $table->bigInteger('giving_1')->unsigned()->nullable();
            $table->bigInteger('giving_2')->unsigned()->nullable();
            $table->bigInteger('giving_3')->unsigned()->nullable();
            $table->bigInteger('giving_4')->unsigned()->nullable();
            $table->integer('giving_currency')->nullable();
            $table->bigInteger('receiving_1')->unsigned()->nullable();
            $table->bigInteger('receiving_2')->unsigned()->nullable();
            $table->bigInteger('receiving_3')->unsigned()->nullable();
            $table->bigInteger('receiving_4')->unsigned()->nullable();
            $table->integer('receiving_currency')->nullable();
            $table->timestamps();

            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('giving_1')->references('id')->on('inventories')->onDelete('set null');
            $table->foreign('giving_2')->references('id')->on('inventories')->onDelete('set null');
            $table->foreign('giving_3')->references('id')->on('inventories')->onDelete('set null');
            $table->foreign('giving_4')->references('id')->on('inventories')->onDelete('set null');
            $table->foreign('receiving_1')->references('id')->on('inventories')->onDelete('set null');
            $table->foreign('receiving_2')->references('id')->on('inventories')->onDelete('set null');
            $table->foreign('receiving_3')->references('id')->on('inventories')->onDelete('set null');
            $table->foreign('receiving_4')->references('id')->on('inventories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trades');
    }
}
