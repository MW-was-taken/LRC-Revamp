<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('password');
            $table->integer('ping')->default(0);

            // Item
            $table->boolean('can_view_item_info')->default(false);
            $table->boolean('can_edit_item_info')->default(false);
            $table->boolean('can_create_hat_items')->default(false);
            $table->boolean('can_create_face_items')->default(false);
            $table->boolean('can_create_gadget_items')->default(false);
            $table->boolean('can_create_head_items')->default(false);

            // User
            $table->boolean('can_edit_user_info')->default(false);
            $table->boolean('can_reset_user_passwords')->default(false);
            $table->boolean('can_view_user_info')->default(false);
            $table->boolean('can_view_user_emails')->default(false);
            $table->boolean('can_give_items')->default(false);
            $table->boolean('can_give_currency')->default(false);
            $table->boolean('can_take_items')->default(false);
            $table->boolean('can_take_currency')->default(false);
            $table->boolean('can_ban_users')->default(false);
            $table->boolean('can_unban_users')->default(false);
            $table->boolean('can_ip_ban_users')->default(false);
            $table->boolean('can_ip_unban_users')->default(false);

            // Pending
            $table->boolean('can_review_pending_assets')->default(false);
            $table->boolean('can_review_pending_reports')->default(false);

            // Forum
            $table->boolean('can_edit_forum_posts')->default(false);
            $table->boolean('can_delete_forum_posts')->default(false);
            $table->boolean('can_pin_forum_posts')->default(false);
            $table->boolean('can_lock_forum_posts')->default(false);

            // Jobs
            $table->boolean('can_view_job_listing_responses')->default(false);
            $table->boolean('can_create_job_listings')->default(false);

            // Management
            $table->boolean('can_manage_forum_topics')->default(false);
            $table->boolean('can_manage_staff')->default(false);
            $table->boolean('can_manage_site')->default(false);

            // Etc
            $table->boolean('can_render_thumbnails')->default(false);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_users');
    }
}
