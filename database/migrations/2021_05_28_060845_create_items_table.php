<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('creator_id');
            $table->string('creator_type')->default('user'); // user, group
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type');
            $table->string('status')->default('pending'); // pending, denied, approved
            $table->integer('price');
            $table->boolean('limited')->default(false);
            $table->integer('stock')->default(0);
            $table->boolean('public_view')->default(true);
            $table->boolean('onsale');
            $table->string('thumbnail_url')->nullable();
            $table->string('filename');
            $table->timestamp('onsale_until')->nullable();
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
        Schema::dropIfExists('items');
    }
}
