<?php
 
namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAvatar extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'user_avatars';

    protected $fillable = [
        'user_id'
    ];

    public function hat($num)
    {
        return Item::where('id', '=', $this->{"hat_{$num}"})->first();
    }

    public function face()
    {
        return Item::where('id', '=', $this->face)->first();
    }

    public function gadget()
    {
        return Item::where('id', '=', $this->gadget)->first();
    }

    public function tshirt()
    {
        return Item::where('id', '=', $this->tshirt)->first();
    }

    public function shirt()
    {
        return Item::where('id', '=', $this->shirt)->first();
    }

    public function pants()
    {
        return Item::where('id', '=', $this->pants)->first();
    }

    public function reset()
    {
        $thumbnail = "thumbnails/{$this->image}.png";
        $headshot = "thumbnails/{$this->image}_headshot.png";

        $this->timestamps = false;
        $this->image = 'default';
        $this->hat_1 = null;
        $this->hat_2 = null;
        $this->hat_3 = null;
        $this->head = null;
        $this->face = null;
        $this->gadget = null;
        $this->tshirt = null;
        $this->shirt = null;
        $this->pants = null;
        $this->color_head = '#d3d3d3';
        $this->color_torso = '#d3d3d3';
        $this->color_left_arm = '#d3d3d3';
        $this->color_right_arm = '#d3d3d3';
        $this->color_left_leg = '#d3d3d3';
        $this->color_right_leg = '#d3d3d3';
        $this->save();

        if (Storage::exists($thumbnail))
            Storage::delete($thumbnail);

        if (Storage::exists($headshot))
            Storage::delete($headshot);
    }
}
