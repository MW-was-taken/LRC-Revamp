<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $table = 'friends';

    protected $fillable = [
        'receiver_id',
        'sender_id'
    ];

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }
}
