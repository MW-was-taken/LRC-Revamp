<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterIP extends Model
{
    use HasFactory;

    protected $table = 'register_ips';

    protected $fillable = [
        'ip'
    ];
}
