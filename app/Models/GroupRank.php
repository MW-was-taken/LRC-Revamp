<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupRank extends Model
{
    use HasFactory;

    protected $table = 'group_ranks';

    protected $fillable = [
        'group_id',
        'name',
        'rank'
    ];

    public function memberCount()
    {
        return number_format(GroupMember::where([
            ['group_id', '=', $this->group_id],
            ['rank', '=', $this->rank]
        ])->count());
    }
}
