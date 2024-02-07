<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    public $tablename = 'profile';
    public $fillable = ['username','acesses'];
    public $dates = ['created_at', 'updated_at'];
}
