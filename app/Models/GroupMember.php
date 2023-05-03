<?php
 
namespace App\Models;

use App\Models\GroupRank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupMember extends Model
{
    use HasFactory;

    protected $table = 'group_members';

    protected $fillable = [
        'user_id',
        'group_id',
        'rank'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group', 'group_id');
    }

    public function rank()
    {
        return GroupRank::where([
            ['group_id', '=', $this->group_id],
            ['rank', '=', $this->rank]
        ])->first();
    }
}
