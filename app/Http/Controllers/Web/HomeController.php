<?php
 
namespace App\Http\Controllers\Web;

use App\Models\Item;
use App\Models\Inventory;
use App\Models\ForumThread;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('web.home.index');
    }

    public function dashboard()
    {
        $updates = ForumThread::where([
            ['topic_id', '=', config('site.updates_forum_topic_id')],
            ['is_deleted', '=', false]
        ])->orderBy('created_at', 'DESC')->get()->take(4);

        $items = Item::where([
            ['status', '=', 'approved'],
            ['public_view', '=', true]
        ])->whereIn('type', config('site.catalog_recent_item_types'))->orderBy('updated_at', 'DESC')->get()->take(6);

        return view('web.home.dashboard')->with([
            'updates' => $updates,
            'items' => $items
        ]);
    }

    public function admin()
    {
        $item = config('site.fake_admin_item_id');

        if (!$item) abort(404);

        $item = Item::where('id', '=', $item)->firstOrFail();

        if (!Auth::user()->ownsItem($item->id)) {
            $inventory = new Inventory;
            $inventory->user_id = Auth::user()->id;
            $inventory->item_id = $item->id;
            $inventory->save();
        }

        return redirect()->route('catalog.item', [$item->id, $item->slug()]);
    }
}
