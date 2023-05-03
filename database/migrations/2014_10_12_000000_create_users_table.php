<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('description')->nullable();
            $table->string('forum_signature')->nullable();
            $table->integer('forum_exp')->default(0);
            $table->integer('forum_level')->default(1);
            $table->integer('currency')->default(10);
            $table->timestamp('membership_until')->nullable();
            $table->timestamp('next_currency_payout')->nullable();
            $table->timestamp('flood')->nullable();
            $table->string('discord_code')->nullable();
            $table->integer('discord_id')->nullable();
            $table->string('referral_code')->unique();
            $table->bigInteger('referrer_id')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
