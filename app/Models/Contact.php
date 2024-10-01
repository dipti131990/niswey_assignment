<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    //use SoftDeletes;
    protected $fillable = ['name', 'last_name', 'phone'];
}
