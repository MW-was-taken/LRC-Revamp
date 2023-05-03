<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetChecksum extends Model
{
    use HasFactory;

    protected $table = 'asset_checksums';

    protected $fillable = [
        'item_id',
        'hash'
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }
}
