<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
     /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'users';

    public function contents(){
    	return $this->hasMany('App\Model\Contents');
	}
}
