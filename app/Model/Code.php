<?php
namespace App\Model;
class Code
{
    /**
     * 封装curl post请求方法
     * @param $url
     * @param $postData
     * @return bool|string
     */
    public function curl_post($url,$postData)
    {
        //初始化
        $ch=curl_init();
        //设置选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//可以请求https
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        //执行
        $output = curl_exec($ch);
        //关闭释放
        curl_close($ch);
        return $output;
    }

    /**
     *   封装curl get请求方法
     * @param $url
     * @return bool|string
     */
    public function curl_get($url)
    {
        //初始化
        $ch=curl_init();
        //设置选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//可以请求https
        //执行
        $output = curl_exec($ch);
        //关闭释放
        curl_close($ch);
        return $output;
    }
}
