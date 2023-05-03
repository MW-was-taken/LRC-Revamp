<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupJoinRequest extends Model
{
    use HasFactory;

    protected $table = 'group_join_requests';

    protected $fillable = [
        'user_id',
        'group_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group', 'group_id');
    }
}
