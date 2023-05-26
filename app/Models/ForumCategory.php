<?php

namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    protected $table = 'forum_categories';

    protected $fillable = [
        'name',
        'home_page_priority',
    ];

    public function topics()
    {
        if (Auth::check() && Auth::user()->isStaff())
            $topics = ForumTopic::where('belongs_to_category', '=', $this->id)->orderBy('home_page_priority', 'DESC');
        else
            $topics = ForumTopic::where([
                ['belongs_to_category', '=', $this->id],
                ['is_staff_only_viewing', '=', false]
            ])->orderBy('home_page_priority', 'DESC');

        return $topics->get();
    }

}
