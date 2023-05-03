<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBan extends Model
{
    use HasFactory;

    protected $table = 'user_bans';

    protected $fillable = [
        'user_id',
        'banner_id',
        'note',
        'category',
        'length',
        'banned_until'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function banner()
    {
        return $this->belongsTo('App\Models\User', 'banner_id');
    }

    public function unbanner()
    {
        return $this->belongsTo('App\Models\User', 'unbanner_id');
    }
}
