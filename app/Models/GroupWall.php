<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupWall extends Model
{
    use HasFactory;

    protected $table = 'group_wall';

    protected $fillable = [
        'user_id',
        'group_id',
        'body'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
