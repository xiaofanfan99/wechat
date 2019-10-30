<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{//接口测试模型
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'test';//设置表名
    protected $primaryKey="test_id";//主键id
    public $timestamps = false;//关闭自动时间戳
    protected $guarded = [];//不能被批量赋值的属性
//    protected $connection = 'mysql_api';//指定链接数据库
}
