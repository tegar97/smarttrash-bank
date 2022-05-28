<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class register_code extends Model
{
    use HasFactory;
    protected $table = 'register_code';
    protected $fillable = ['rfid','code'];
}
