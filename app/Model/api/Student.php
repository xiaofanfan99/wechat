<?php

namespace App\Model\api;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //商品接口
    /**周天作业 学生信息
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'student';//设置表名
    protected $primaryKey="stu_id";//主键id
    public $timestamps = false;//关闭自动时间戳
    protected $guarded = [];//不能被批量赋值的属性
    protected $connection = 'mysql_api';//指定链接数据库
}
