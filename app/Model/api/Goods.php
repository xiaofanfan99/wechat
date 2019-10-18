<?php

namespace App\Model\api;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{   //商品接口
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'api_goods';//设置表名
    protected $primaryKey="goods_id";//主键id
    public $timestamps = false;//关闭自动时间戳
    protected $guarded = [];//不能被批量赋值的属性
}
