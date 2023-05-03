<?php
 
namespace App\Http\Controllers\Web\Account;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        switch ($request->category) {
            case '':
            case 'incoming':
                $error = 'You do not have any incoming messages.';
                $info = [
                    ['receiver_id', '=', Auth::user()->id],
                    ['seen', '=', false]
                ];
                break;
            case 'sent':
                $error = 'You have not sent any messages.';
                $info = [
                    ['sender_id', '=', Auth::user()->id]
                ];
                break;
            case 'history':
                $error = 'You do not have any history.';
                $info = [
                    ['receiver_id', '=', Auth::user()->id],
                    ['seen', '=', true]
                ];
                break;
            default:
                abort(404);
        }

        $category = ($request->category == '') ? 'incoming' : $request->category;
        $messages = Message::where($info)->orderBy('created_at', 'DESC')->paginate(15);

        return view('web.account.inbox.index')->with([
            'category' => $category,
            'messages' => $messages,
            'error' => $error
        ]);
    }

    public function message($id)
    {
        $message = Message::where([
            ['id', '=', $id],
            ['receiver_id', '=', Auth::user()->id]
        ])->orWhere([
            ['id', '=', $id],
            ['sender_id', '=', Auth::user()->id]
        ])->firstOrFail();

        if (!$message->seen && Auth::user()->id == $message->receiver_id) {
            $message->seen = true;
            $message->save();
        }

        return view('web.account.inbox.message')->with([
            'message' => $message
        ]);
    }

    public function new($type, $id)
    {
        switch ($type) {
            case 'message':
                $user = User::where('username', '=', $id)->firstOrFail();
                $title = "Send a message to {$user->username}";
                $id = $user->id;

                if ($user->id == Auth::user()->id || !$user->setting->accepts_messages) abort(404);
                break;
            case 'reply':
                $message = Message::where([
                    ['id', '=', $id],
                    ['receiver_id', '=', Auth::user()->id]
                ])->firstOrFail();
                $title = "Reply to {$message->sender->username}'s Message";

                if ($message->sender->id == Auth::user()->id) abort(404);
                break;
            default:
                abort(404);
        }

        return view('web.account.inbox.new')->with([
            'title' => $title,
            'type' => $type,
            'id' => $id
        ]);
    }

    public function create(Request $request)
    {
        switch ($request->type) {
            case 'message':
                $user = User::where('id', '=', $request->id)->firstOrFail();

                if ($user->id == Auth::user()->id || !$user->setting->accepts_messages) abort(404);

                $this->validate($request, [
                    'title' => ['required', 'max:50'],
                    'body' => ['required', 'min:3', 'max:7500']
                ]);

                $message = new Message;
                $message->receiver_id = $user->id;
                $message->sender_id = Auth::user()->id;
                $message->title = $request->title;
                $message->body = $request->body;
                $message->save();

                return redirect()->route('account.inbox.message', $message->id)->with('success_message', 'Message has been sent.');
                break;
            case 'reply':
                $message = Message::where([
                    ['id', '=', $request->id],
                    ['receiver_id', '=', Auth::user()->id]
                ])->firstOrFail();

                if ($message->sender->id == Auth::user()->id) abort(404);

                $this->validate($request, [
                    'body' => ['required', 'min:3', 'max:7500']
                ]);

                $reply = new Message;
                $reply->receiver_id = $message->sender->id;
                $reply->sender_id = Auth::user()->id;
                $reply->title = "RE: {$message->title}";
                $reply->body = "{$request->body}\n\n------------------------------\nOn {$message->created_at->format('M d, Y')}, {$message->sender->username} wrote:\n{$message->body}";
                $reply->save();

                return redirect()->route('account.inbox.message', $reply->id)->with('success_message', 'Reply has been sent.');
                break;
            default:
                abort(404);
        }
    }
}
