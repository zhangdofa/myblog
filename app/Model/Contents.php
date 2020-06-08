<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contents extends Model
{
    //
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'contents';
    protected $fillable = ['title','content','user_id','id'];
    public $timestamps = false;

    //关联用户  文章属于用户  文章的user_id关联用户的id
    public function user(){
        return $this->belongsTo('App\Model\User','user_id','id');
    }

    //    关联赞  一篇文章 一个用户只能一个赞  判断某个用户对文章是否有赞
    public function zan($user_id){
        return $this->hasOne('App\Model\Zan')->where('user_id',$user_id);
    }

	//获取文章的所有赞 一篇文章有多个赞
    public function zans(){
        return   $this->hasMany('App\Model\Zan');
    }

    //获取文章的所有评论一篇文章有多条评论
    public function comments(){
        return   $this->hasMany('App\Model\Comments');
    }
}
