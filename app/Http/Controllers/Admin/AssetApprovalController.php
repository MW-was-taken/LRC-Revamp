<?php
 
namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Group;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\AssetChecksum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AssetApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (!staffUser()->staff('can_review_pending_assets')) abort(404);

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $storage = config('site.route_domains.storage_site');
        $totalItems = Item::where('status', '=', 'pending')->count();
        $totalLogos = Group::where('is_thumbnail_pending', '=', true)->count();

        switch ($request->category) {
            case '':
            case 'items':
                $category = 'items';
                $type = 'item';
                $assets = Item::where('status', '=', 'pending')->orderBy('created_at', 'DESC')->paginate(12);

                foreach ($assets as $asset) {
                    $asset->image = "{$storage}/uploads/{$asset->filename}.png";
                    $asset->url = route('catalog.item', [$asset->id, $asset->slug()]);
                    $asset->creator_url = $asset->creatorUrl();
                    $asset->creator_name = $asset->creatorName();
                }
                break;
            case 'logos':
                $category = 'logos';
                $type = 'group';
                $assets = Group::where('is_thumbnail_pending', '=', true)->orderBy('created_at', 'DESC')->paginate(12);

                foreach ($assets as $asset) {
                    $asset->image = "{$storage}/{$asset->thumbnail_url}";
                    $asset->url = route('groups.view', [$asset->id, $asset->slug()]);
                    $asset->creator_url = route('users.profile', $asset->owner->username);
                    $asset->creator_name = $asset->owner->username;
                }
                break;
            default:
                abort(404);
        }

        return view('admin.asset_approval')->with([
            'totalItems' => $totalItems,
            'totalLogos' => $totalLogos,
            'category' => $category,
            'type' => $type,
            'assets' => $assets
        ]);
    }

    public function update(Request $request)
    {
        if (!in_array($request->type, ['item', 'group'])) abort(404);

        switch ($request->type) {
            case 'item':
            $item = Item::where('id', '=', $request->id)->firstOrFail();
            $item->timestamps = false;

            if ($item->status != 'pending')
                return back()->withErrors(['This item has already been moderated.']);

            switch ($request->action) {
                case 'approve':
                    render($item->id, 'item');

                    $hash = md5_file(Storage::path("uploads/{$item->filename}.png"));
                    $hash = "{$item->type}_{$hash}";

                    $item->status = 'approved';
                    $item->save();

                    $inventory = new Inventory;
                    $inventory->user_id = ($item->creator_type == 'user') ? $item->creator->id : $item->creator->owner->id;
                    $inventory->item_id = $item->id;
                    $inventory->save();

                    $checksum = new AssetChecksum;
                    $checksum->item_id = $item->id;
                    $checksum->hash = $hash;
                    $checksum->save();

                    return back()->with('success_message', 'Item has been approved.');
                case 'deny':
                    $hash = md5_file(Storage::path("uploads/{$item->filename}.png"));
                    $hash = "{$item->type}_{$hash}";

                    $item->status = 'denied';
                    $item->save();

                    $checksum = new AssetChecksum;
                    $checksum->item_id = $item->id;
                    $checksum->hash = $hash;
                    $checksum->save();

                    return back()->with('success_message', 'Item has been denied.');
                default:
                    abort(404);
            }
        case 'group':
            $group = Group::where('id', '=', $request->id)->firstOrFail();
            $group->timestamps = false;

            if (!$group->is_thumbnail_pending)
                return back()->withErrors(['This logo has already been moderated.']);

            switch ($request->action) {
                case 'approve':
                    $group->is_thumbnail_pending = false;
                    $group->save();

                    return back()->with('success_message', 'Logo has been approved.');
                case 'deny':
                    if (Storage::exists("thumbnails/{$group->thumbnail_url}.png"))
                        Storage::delete("thumbnails/{$group->thumbnail_url}.png");

                    $group->is_thumbnail_pending = false;
                    $group->thumbnail_url = 'denied';
                    $group->save();

                    return back()->with('success_message', 'Logo has been denied.');
                default:
                    abort(404);
            }
        }
    }
}
