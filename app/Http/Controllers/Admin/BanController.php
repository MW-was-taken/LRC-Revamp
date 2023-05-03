<?php
 
namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserBan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BanController extends Controller
{
    public const BAN_LENGTHS = [
        'Warning' => 'warning',
        '12 Hours' => '12_hours',
        '1 Day' => '1_day',
        '3 Days' => '3_days',
        '7 Days' => '7_days',
        '14 Days' => '14_days',
        'Close Account' => 'closed'
    ];

    public const BAN_LENGTH_TIMES = [
        'warning' => 1,
        '12_hours' => 43200,
        '1_day' => 86400,
        '3_days' => 259200,
        '7_days' => 604800,
        '14_days' => 1209600,
        'closed' => 31536000
    ];

    public const BAN_CATEGORIES = [
        'Spam' => 'spam',
        'Profanity' => 'profanity',
        'Sensitive Topics' => 'sensitive_topics',
        'Offsite Links' => 'offsite_links',
        'Harassment' => 'harassment',
        'Discrimination' => 'discrimination',
        'Sexual Content' => 'sexual_content',
        'Inappropriate Content' => 'inappropriate_content',
        'False Information' => 'false_information',
        'Other' => 'other'
    ];

    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (!staffUser()->staff('can_ban_users')) abort(404);

            return $next($request);
        });
    }

    public function index($id)
    {
        $user = User::where('id', '=', $id)->firstOrFail();
        $lengths = $this::BAN_LENGTHS;
        $categories = $this::BAN_CATEGORIES;

        if ($user->isStaff() && !staffUser()->staff('can_manage_staff'))
            return back()->withErrors(['You can not ban this user.']);

        if ($user->isBanned())
            return back()->withErrors(['This user is already banned.']);

        return view('admin.ban')->with([
            'user' => $user,
            'lengths' => $lengths,
            'categories' => $categories
        ]);
    }

    public function create(Request $request)
    {
        $user = User::where('id', '=', $request->id)->firstOrFail();

        if ($user->isStaff() && !staffUser()->staff('can_manage_staff'))
            return back()->withErrors(['You can not ban this user.']);

        if ($user->isBanned())
            return back()->withErrors(['This user is already banned.']);

        if (!in_array($request->length, $this::BAN_LENGTHS))
            return back()->withErrors(['Invalid length.']);

        if (!in_array($request->category, $this::BAN_CATEGORIES))
            return back()->withErrors(['Invalid category.']);

        $ban = new UserBan;
        $ban->user_id = $user->id;
        $ban->banner_id = staffUser()->id;
        $ban->note = $request->note;
        $ban->category = $request->category;
        $ban->length = $request->length;
        $ban->banned_until = Carbon::createFromTimestamp(time() + $this::BAN_LENGTH_TIMES[$request->length])->format('Y-m-d H:i:s');
        $ban->save();

        return redirect()->route('users.profile', $user->username)->with('success_message', 'User has been banned.');
    }
}
