<?php
 
namespace App\Http\Controllers\Admin\Manage;

use App\Models\ForumTopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumTopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (!staffUser()->staff('can_manage_forum_topics')) abort(404);

            return $next($request);
        });
    }

    public function index()
    {
        $topics = ForumTopic::orderBy('home_page_priority', 'DESC')->paginate(25);

        return view('admin.manage.forum_topics.index')->with([
            'topics' => $topics
        ]);
    }

    public function new()
    {
        return view('admin.manage.forum_topics.new');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:50'],
            'description' => ['required', 'min:3', 'max:7500'],
            'home_page_priority' => ['required', 'numeric', 'min:1', 'max:255']
        ]);

        $topic = new ForumTopic;
        $topic->name = $request->name;
        $topic->description = $request->description;
        $topic->home_page_priority = $request->home_page_priority;
        $topic->is_staff_only_viewing = $request->has('is_staff_only_viewing');
        $topic->is_staff_only_posting = ($request->has('is_staff_only_posting') || $request->has('is_staff_only_viewing'));
        $topic->save();

        return redirect()->route('admin.manage.forum_topics.index')->with('success_message', 'Topic has been created.');
    }

    public function edit($id)
    {
        $topic = ForumTopic::where('id', '=', $id)->firstOrFail();

        return view('admin.manage.forum_topics.edit')->with([
            'topic' => $topic
        ]);
    }

    public function update(Request $request)
    {
        $topic = ForumTopic::where('id', '=', $request->id)->firstOrFail();

        $this->validate($request, [
            'name' => ['required', 'max:50'],
            'description' => ['required', 'min:3', 'max:7500'],
            'home_page_priority' => ['required', 'numeric', 'min:1', 'max:255']
        ]);

        $topic->name = $request->name;
        $topic->description = $request->description;
        $topic->home_page_priority = $request->home_page_priority;
        $topic->is_staff_only_viewing = $request->has('is_staff_only_viewing');
        $topic->is_staff_only_posting = ($request->has('is_staff_only_posting') || $request->has('is_staff_only_viewing'));
        $topic->save();

        return redirect()->route('admin.manage.forum_topics.index')->with('success_message', 'Topic has been updated.');
    }

    public function confirmDelete($id)
    {
        $topic = ForumTopic::where('id', '=', $id)->firstOrFail();

        return view('admin.manage.forum_topics.delete')->with([
            'topic' => $topic
        ]);
    }

    public function delete(Request $request)
    {
        $topic = ForumTopic::where('id', '=', $request->id)->firstOrFail();
        $topic->delete();

        return redirect()->route('admin.manage.forum_topics.index')->with('success_message', "The \"{$topic->name}\" topic has been deleted.");
    }
}
