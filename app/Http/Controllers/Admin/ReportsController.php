<?php
 
namespace App\Http\Controllers\Admin;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public const REPORT_CATEGORIES = [
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

    public const REPORT_CATEGORIES_LONG = [
        'This content is spam' => 'spam',
        'This content contains bad words' => 'profanity',
        'This content discusses sensitive topics' => 'sensitive_topics',
        'This content contains offsite links' => 'offsite_links',
        'This content harasses me or someone else' => 'harassment',
        'This content contains discrimination' => 'discrimination',
        'This content contains sexual content' => 'sexual_content',
        'This content contains inappropriate content' => 'inappropriate_content',
        'This content is spreading false information' => 'false_information',
        'Other' => 'other'
    ];

    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (!staffUser()->staff('can_review_pending_reports')) abort(404);

            return $next($request);
        });
    }

    public function index()
    {
        $reports = Report::where('is_seen', '=', false)->orderBy('created_at', 'DESC')->paginate(12);

        foreach ($reports as $report) {
            $report->category = array_search($report->category, $this::REPORT_CATEGORIES);

            if ($report->type == 'user')
                $report->reported_user_id = $report->id;
            else if ($report->content->creator_id)
                $report->reported_user_id = $report->content->creator_id;
            else if ($report->content->owner_id)
                $report->reported_user_id = $report->content->owner_id;
            else if ($report->user_id)
                $report->reported_user_id = $report->content->user_id;
            else if ($report->sender_id)
                $report->reported_user_id = $report->content->sender_id;
        }

        return view('admin.reports')->with([
            'reports' => $reports
        ]);
    }

    public function update(Request $request)
    {
        $report = Report::where('id', '=', $request->id)->firstOrFail();

        if ($report->is_seen)
            return back()->withErrors(['This report has already been dealt with.']);

        $report->reviewer_id = staffUser()->id;
        $report->is_seen = true;
        $report->save();

        return back()->with('success_message', 'Report has been marked as seen.');
    }
}
