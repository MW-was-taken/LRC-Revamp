<?php
 
namespace App\Http\Controllers\API;

use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function search(Request $request)
    {
        $json = [];
        $error = "No {$request->category} found.";
        $type = lcfirst(itemTypeFromPlural($request->category));

        if (!empty($request->search))
            $error = 'This search returned no results.';

        if (!in_array($type, config('site.catalog_item_types')))
            return response()->json(['error' => 'Invalid category.']);

        $items = Item::where([
            ['name', 'LIKE', "%{$request->search}%"],
            ['type', '=', $type],
            ['status', '=', 'approved'],
            ['public_view', '=', true]
        ]);

        if ($items->count() == 0)
            return response()->json(['error' => $error]);

        $items = $items->orderBy('updated_at', 'DESC')->paginate(8);

        foreach ($items as $item)
            $json[] = [
                'name'      => (string) $item->name,
                'type'      => (string) $item->type,
                'thumbnail' => (string) $item->thumbnail(),
                'price'     => (integer) $item->price,
                'onsale'    => (boolean) $item->onsale(),
                'limited'   => (boolean) $item->limited,
                'timed'     => (boolean) $item->isTimed(),
                'stock'     => (integer) $item->stock,
                'url'       => (string) route('catalog.item', [$item->id, $item->slug()]),
                'creator'   => [
                    'username' => (string) $item->creatorName(),
                    'image'    => (string) $item->creatorImage(),
                    'url'      => (string) $item->creatorUrl()
                ]
            ];

        return response()->json(['current_page' => $items->currentPage(), 'total_pages' => $items->lastPage(), 'items' => $json]);
    }
}
