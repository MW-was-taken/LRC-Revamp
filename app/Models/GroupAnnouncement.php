<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupAnnouncement extends Model
{
    use HasFactory;

    protected $table = 'group_announcements';

    protected $fillable = [
        'user_id',
        'group_id',
        'title',
        'body'
    ];
}
