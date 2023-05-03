<?php
 
namespace App\Http\Controllers\Web\Account;

use App\Models\ItemPurchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MoneyController extends Controller
{
    public function index(Request $request)
    {
        switch ($request->category) {
            case '':
            case 'purchases':
                $category = 'purchases';
                $transactions = ItemPurchase::where('buyer_id', '=', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
                break;
            case 'sales':
                $category = 'sales';
                $transactions = ItemPurchase::where('seller_id', '=', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
                break;
            default:
                abort(404);
        }

        return view('web.account.money')->with([
            'category' => $category,
            'transactions' => $transactions ?? null
        ]);
    }
}
