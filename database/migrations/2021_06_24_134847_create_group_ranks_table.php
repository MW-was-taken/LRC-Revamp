<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_ranks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('group_id')->unsigned();
            $table->string('name');
            $table->integer('rank');
            $table->boolean('can_view_wall')->default(false);
            $table->boolean('can_post_on_wall')->default(false);
            $table->boolean('can_moderate_wall')->default(false);
            $table->boolean('can_change_ranks')->default(false);
            $table->boolean('can_kick_members')->default(false);
            $table->boolean('can_accept_members')->default(false);
            $table->boolean('can_post_announcements')->default(false);
            $table->boolean('can_spend_funds')->default(false);
            $table->boolean('can_create_items')->default(false);
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_ranks');
    }
}
