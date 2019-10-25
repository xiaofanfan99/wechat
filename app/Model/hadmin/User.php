<?php

namespace App\Model\hadmin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //商品接口
    /** 用户表模型
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'user';//设置表名
    protected $primaryKey="user_id";//主键id
    public $timestamps = false;//关闭自动时间戳
    protected $guarded = [];//不能被批量赋值的属性
    protected $connection = 'mysql_api';//指定链接数据库
}
