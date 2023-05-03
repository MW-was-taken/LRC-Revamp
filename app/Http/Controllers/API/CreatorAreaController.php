<?php
 
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CreatorAreaController extends Controller
{
    public function renderPreview(Request $request)
    {
        if (!config('site.renderer.previews_enabled'))
            abort(404);

        $validator = Validator::make($request->all(), [
            'file' => ['required', 'dimensions:min_width=1024,max_height=1024,min_height=1024,max_height=1024', 'mimes:png,jpg,jpeg', 'max:2048']
        ]);

        if (!in_array($request->type, ['shirt', 'pants']) || $validator->fails())
            return response()->json(['error' => 'Invalid file.']);

        Storage::putFileAs('uploads', $request->file('file'), "preview_{$request->type}.png");

        $data = render($request->type, 'preview');

        return response()->json(['thumbnail' => $data]);
    }
}
