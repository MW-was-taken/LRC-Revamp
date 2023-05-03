<?php
 
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('maintenance_enabled')->default(false);
            $table->boolean('alert_enabled')->default(false);
            $table->text('alert_message')->nullable();
            $table->string('alert_background_color')->default('orange');
            $table->string('alert_text_color')->default('#fff');
            $table->boolean('catalog_purchases_enabled')->default(true);
            $table->boolean('forum_enabled')->default(true);
            $table->boolean('create_enabled')->default(true);
            $table->boolean('character_enabled')->default(true);
            $table->boolean('trading_enabled')->default(true);
            $table->boolean('groups_enabled')->default(true);
            $table->boolean('settings_enabled')->default(true);
            $table->boolean('real_life_purchases_enabled')->default(true);
            $table->boolean('registration_enabled')->default(true);
        });

        DB::table('site_settings')->insert(['id' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
}
