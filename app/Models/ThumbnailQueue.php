<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThumbnailQueue extends Model
{
    use HasFactory;

    protected $table = 'thumbnail_queue';

    public function asset()
    {
        switch ($this->type) {
            case 'user':
                return $this->belongsTo('App\Models\User', 'asset_id');
            case 'item':
                return $this->belongsTo('App\Models\Item', 'asset_id');
        }
    }
}
