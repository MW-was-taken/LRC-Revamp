<?php
 
namespace App\Models;

use App\Models\Inventory;
use App\Models\ItemPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'creator_id',
        'creator_type',
        'name',
        'description',
        'type',
        'status',
        'price',
        'limited',
        'stock',
        'public_view',
        'onsale',
        'thumbnail_url',
        'filename',
        'onsale_until'
    ];

    protected $casts = [
        'onsale_until' => 'datetime'
    ];

    public function creator()
    {
        switch ($this->creator_type) {
            case 'user':
                return $this->belongsTo('App\Models\User', 'creator_id');
            case 'group':
                return $this->belongsTo('App\Models\Group', 'creator_id');
        }
    }

    public function creatorUrl()
    {
        switch ($this->creator_type) {
            case 'user':
                return route('users.profile', $this->creator->username);
            case 'group':
                return route('groups.view', [$this->creator->id, $this->creator->slug()]);
        }
    }

    public function creatorName()
    {
        switch ($this->creator_type) {
            case 'user':
                return $this->creator->username;
            case 'group':
                return $this->creator->name;
        }
    }

    public function creatorImage()
    {
        $url = config('site.storage_url');

        switch ($this->creator_type) {
            case 'user':
                return $this->creator->headshot();
            case 'group':
                return "{$url}/{$this->creator->thumbnail_url}";
        }
    }

    public function thumbnail()
    {
        if ($this->status != 'approved')
            return asset("img/{$this->status}.png");

        $url = config('site.storage_url');

        return "{$url}/{$this->thumbnail_url}.png";
    }

    public function slug()
    {
        $name = str_replace('-', ' ', $this->name);

        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }

    public function isTimed()
    {
        return !empty($this->onsale_until) && strtotime($this->onsale_until) > time();
    }

    public function onsale()
    {
        if ($this->onsale_until && strtotime($this->onsale_until) < time())
            return false;

        return $this->onsale;
    }

    public function owners()
    {
        return Inventory::where('item_id', '=', $this->id)->get();
    }

    public function sold()
    {
        return ItemPurchase::where('item_id', '=', $this->id)->get();
    }

    public function resellers()
    {
        return ItemReseller::where('item_id', '=', $this->id)->orderBy('price', 'ASC')->paginate(10);
    }
}
