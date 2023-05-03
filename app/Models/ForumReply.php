<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    use HasFactory;

    protected $table = 'forum_replies';

    protected $fillable = [
        'thread_id',
        'quote_id',
        'creator_id',
        'body'
    ];

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }

    public function quote()
    {
        return $this->belongsTo('App\Models\ForumReply', 'quote_id');
    }

    public function thread()
    {
        return $this->belongsTo('App\Models\ForumThread', 'thread_id');
    }
}
