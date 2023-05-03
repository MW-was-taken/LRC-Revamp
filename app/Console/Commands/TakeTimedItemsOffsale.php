<?php
 
namespace App\Console\Commands;

use App\Models\Item;
use Illuminate\Console\Command;

class TakeTimedItemsOffsale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offsale:timed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes offsale all expired timed items.';

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
        $items = Item::where('onsale_until', '!=', null)->get();

        foreach ($items as $item) {
            if (strtotime($item->onsale_until) < time()) {
                $item->timestamps = false;
                $item->onsale = false;
                $item->onsale_until = null;
                $item->save();
            }
        }
    }
}
