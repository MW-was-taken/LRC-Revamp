<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reporter_id')->unsigned();
            $table->bigInteger('reviewer_id')->unsigned()->nullable();
            $table->integer('content_id');
            $table->string('type'); // user, status, item, item-comment, forum-thread, forum-reply, group, group-wall-post, message
            $table->string('category');
            $table->text('comment')->nullable();
            $table->boolean('is_seen')->default(false);
            $table->timestamps();

            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
