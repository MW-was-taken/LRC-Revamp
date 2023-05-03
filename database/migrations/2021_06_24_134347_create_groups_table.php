<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('vault')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_private')->default(false);
            $table->boolean('is_vault_viewable')->default(true);
            $table->boolean('is_locked')->default(false);
            $table->string('thumbnail_url');
            $table->boolean('is_thumbnail_pending')->default(true);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
