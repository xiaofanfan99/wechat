<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\hadmin\User;
use App\Model\api\News;
class NewsTestController extends Controller
{
    public function curl_get($url)
    {
        //初始化
        $ch = curl_init();
        //设置选项
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        //如果是https访问
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        //执行
        $output = curl_exec($ch);
        //关闭
        curl_close($ch);
        return $output;
    }
    /**
     * 阿凡达新闻接口开发
     */
    public function news()
    {
        //PHP执行时间超过了30秒的限制   设置php超常时间
        set_time_limit(100);
        //获取实时热点 新闻
        $url="http://api.avatardata.cn/ActNews/LookUp?key=d82a548af2bd4c4cb3c1867ce3b8e701";
        $hot_news=$this->curl_get($url);
        $hot_news=json_decode($hot_news,1);
//        var_dump($hot_news);
        $news_arr=[];
        //取前十条
        for ($i = 0; $i <= 9; $i++){
            $news_arr[]=$hot_news['result'][$i];
        }
        if(!$news_arr){//判断新闻更新 时更新数据库新闻
            //        $news_arr=['王者荣耀','明月照我心','韩剧','韩美娟'];
            foreach ($news_arr as $k=>$v){
                $url="http://api.avatardata.cn/ActNews/Query?key=d82a548af2bd4c4cb3c1867ce3b8e701&keyword=$v";
                $new_data = $this->curl_get($url);
                $new_data = json_decode($new_data,1);
                foreach ($new_data['result'] as $key=>$value){
                    //判断数据库新闻存在不入库  查询数据库
                    $news_data=News::where(['title'=>$value['title']])->first();
                    if(!$news_data){//不存在添加数据库
                        News::create([
                            'title'=>$value['title'],
                            'content'=>$value['content'],
                            'pdate_src'=>$value['pdate_src'],
                            'pdate'=>$value['pdate'],
                            'src'=>$value['src'],
                            'img'=>$value['img']
                        ]);
                    }
                }
            }
//            return redirect('api/newstset/news_show');
            return json_encode(['ret'=>1,'msg'=>'数据已是最新']);
        }else{//无则直接跳转新闻展示
//            return redirect('api/newstset/news_show');
            return json_encode(['ret'=>2,'msg'=>'更新成功']);
        }
    }

    /**
     * 接口展示
     */
    public function news_list()
    {
        //查看新闻表信息
//        $news_data = News::get()->toArray();
        $news_data=News::paginate(10)->toArray();
        //接口返回
        return json_encode(['ret'=>1,'data'=>$news_data]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 新闻展示页
     */
    public function news_show()
    {
        return view('api.newstest.newsshow');
    }

    /**
     * 用户注册接口
     */
    public function regist()
    {
        return view('api.newstest.regist');
    }

    /**
     * 注册执行
     * @param Request $request
     */
    public function regist_do(Request $request)
    {
        $username=$request->input('username');
//        dd($username);
        $password=$request->input('password');
        //添加数据库
        User::create([
            'username'=>$username,
            'password'=>$password,
        ]);
        return json_encode(['ret'=>1,'msg'=>'注册成功']);

    }

    /**
     * 用户登录接口
     */
    public function login()
    {
        return view('api.newstest.login');
    }

    /**
     * 登录执行页
     */
    public function login_do(Request $request)
    {
        $username=$request->input('username');
//        dd($username);
        $password=$request->input('password');
        $user_data=User::where(['username'=>$username])->first();
//        var_dump($user_data);
        if(!$user_data){
            return json_encode(['ret'=>1,'msg'=>'用户不存在']);
        }
        if($password!=$user_data->password){
            return json_encode(['ret'=>1,'msg'=>'用户不存在']);
        }
        $token=md5($user_data->user_id.time());
        $user_data->token=$token;
        $user_data->expire_time=time()+7200;//过期时间 7200两小时  3600 一小时
        $user_data->save();//进行数据库修改
        //吧token返还给前台
        return json_encode(['ret'=>1,'msg'=>'登录成功','token'=>$token]);

    }
}
