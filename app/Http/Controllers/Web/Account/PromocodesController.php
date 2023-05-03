<?php
 
namespace App\Http\Controllers\Web\Account;

use App\Models\Item;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PromocodesController extends Controller
{
    public function index()
    {
        $codes = config('promocodes');
        $items = [];

        foreach ($codes as $code => $id) {
            $item = Item::where('id', '=', $id);
            
            if ($item->exists())
                $items[] = $item->first();
        }

        return view('web.account.promocodes')->with([
            'items' => $items
        ]);
    }

    public function redeem(Request $request)
    {
        $code = strtoupper($request->code);
        $codes = config('promocodes');

        if (!$request->has('code'))
            return response()->json(['error' => 'Please provide a code to redeem.']);

        if (!array_key_exists($code, $codes))
            return response()->json(['error' => "Invalid code. This code doesn't exist or has expired."]);

        $item = $codes[$code];
        $owns = Auth::user()->ownsItem($item);

        if ($owns)
            return response()->json(['error' => 'This code has already been redeemed on your account.']);

        $inventory = new Inventory;
        $inventory->user_id = Auth::user()->id;
        $inventory->item_id = $item;
        $inventory->save();

        return response()->json(['message' => 'This code has been successfully redeemed and the item provided has been added to your inventory.']);
    }
}
