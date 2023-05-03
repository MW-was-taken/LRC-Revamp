<?php
 
namespace App\Http\Controllers\API;

use App\Models\Item;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function all(Request $request)
    {
        $json = [];
        $search = (isset($request->search)) ? trim($request->search) : '';

        if (Str::startsWith($search, '%'))
            $search = '';

        $users = User::where('username', 'LIKE', "%{$search}%")->get();

        $items = Item::where([
            ['name', 'LIKE', "%{$search}%"],
            ['public_view', '=', true],
            ['status', '=', 'approved']
        ])->get();

        $groups = Group::where([
            ['name', 'LIKE', "%{$search}%"],
            ['is_locked', '=', false]
        ])->get();

        foreach ($users as $user)
            $user->result_type = 'user';

        foreach ($items as $item)
            $item->result_type = 'item';

        foreach ($groups as $group)
            $group->result_type = 'group';

        $results = $users->merge($items)->merge($groups)->forPage($request->page, 9);

        if ($results->count() == 0 || !$search)
            return response()->json(['error' => 'No results found.']);

        foreach ($results as $result) {
            switch ($result->result_type) {
                case 'user':
                    $name = $result->username;
                    $image = $result->headshot();
                    $url = route('users.profile', $result->username);
                    break;
                case 'item':
                    $name = $result->name;
                    $image = $result->thumbnail();
                    $url = route('catalog.item', [$result->id, $result->slug()]);
                    break;
                case 'group':
                    $name = $result->name;
                    $image = $result->thumbnail();
                    $url = route('groups.view', [$result->id, $result->slug()]);
                    break;
            }

            $json[] = [
                'name' => $name,
                'image' => $image,
                'url' => $url
            ];
        }

        return response()->json($json);
    }
}
