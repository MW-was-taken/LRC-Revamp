<?php
 
namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;

class RenderItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'render:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renders all items.';

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
        $items = Item::where('status', '=', 'approved')->get();

        foreach ($items as $item) {
            render($item->id, 'item');
            sleep(3);
        }
    }
}
