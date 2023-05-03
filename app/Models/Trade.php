<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $table = 'trades';

    protected $fillable = [
        'receiver_id',
        'sender_id',
        'giving_1',
        'giving_2',
        'giving_3',
        'giving_4',
        'giving_currency',
        'receiving_1',
        'receiving_2',
        'receiving_3',
        'receiving_4',
        'receiving_currency'
    ];

    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id');
    }

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }
}
