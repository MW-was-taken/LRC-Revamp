<?php
 
namespace App\Http\Controllers\Web;

use App\Models\StaffUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function index($document)
    {
        $view = $document;
        $variables = [];

        switch ($document) {
            case 'terms':
                $title = 'Terms of Service';
                break;
            case 'privacy':
                $title = 'Privacy Policy';
                break;
            case 'team':
                $title = 'Team';
                $variables['users'] = [];
                $staffUsers = StaffUser::where('user_id', '!=', 1)->orderBy('created_at', 'ASC')->get();

                foreach ($staffUsers as $staffUser)
                    $variables['users'][] = $staffUser->user;
                break;
            default:
                abort(404);
        }

        return view('web.info.index')->with([
            'title' => $title,
            'document' => $document,
            'view' => $view,
            'variables' => $variables
        ]);
    }
}
