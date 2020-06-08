<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $table = 'comments';
    protected $fillable = ['id','contents_id','user_id'];
     //一对多的反向  多个评论属于文章
    public function post(){
        return $this->belongsTo('App\Model\Contents','user_id','id');
    }
 
    //一对多的反向  多个评论属于用户
    public function user(){
        return $this->belongsTo('App\Model\User','user_id','id');
    }

}
