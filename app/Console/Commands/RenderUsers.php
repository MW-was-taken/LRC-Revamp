<?php
 
namespace App\Console\Commands;

use App\Models\UserAvatar;
use Illuminate\Console\Command;

class RenderUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'render:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renders all users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = UserAvatar::where('image', '!=', 'default')->get();

        foreach ($users as $user) {
            render($user->user_id, 'user');
            sleep(3);
        }
    }
}
