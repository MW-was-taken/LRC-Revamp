<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsernameHistory extends Model
{
    use HasFactory;

    protected $table = 'username_history';

    protected $fillable = [
        'user_id',
        'ip',
        'username'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
