<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Zan extends Model
{
    //
    protected $table = "zans";
    protected $fillable = ['id','contents_id','user_id'];
}
