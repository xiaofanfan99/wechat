<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Tools\tools;
use DB;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $tools = new Tools();
            //获取用户列表
            $user_list = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $tools->get_wechat_access_token() . "&next_openid=");
            $user_res = json_decode($user_list, 1);
            foreach ($user_res['data']['openid'] as $v) {
                //获取用户的详细信息
                $user_info = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $tools->get_wechat_access_token() . "&openid=" . $v . "&lang=zh_CN");
                $user = json_decode($user_info, 1);
                //查询数据库是否存在
                $db_user = DB::table('wechat_openid')->where(['openid' => $v])->first();
                if (empty($db_user)) {
                    //不存在添加数据库
                    DB::table('wechat_openid')->insert([
                        'openid' => $v,
                        'add_time' => time()
                    ]);
                    //就是未签到
                    $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $tools->get_wechat_access_token();
                    $data = [
                        'touser' => $v,
                        'template_id' => "ulXe7l_78hvEU0gjlQSnPbFxi2kueNd-SYTH75EVNfU",
                        'data' => [
                            "keyword1" => [
                                "value" => $user['nickname'],
                                "color" => "#ffc0cb"
                            ],
                            "keyword2" => [
                                "value" => "未签到！",
                                "color" => "#173177"
                            ],
                            "keyword3" => [
                                "value" => "0",
                                "color" => "#173177"
                            ],
                            "keyword4" => [
                                "value" => '',
                                "color" => "#173177"
                            ],
                        ]
                    ];
                    $tools->curl_post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
                } else {
                    //判断是否签到
                    $today = date('Y-m-d', time());
                    if ($db_user->sign_day == $today) {
                        //已经签到
                        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $tools->get_wechat_access_token();
                        $data = [
                            'touser' => $v,
                            'template_id' => "ulXe7l_78hvEU0gjlQSnPbFxi2kueNd-SYTH75EVNfU",
                            'data' => [
                                "keyword1" => [
                                    "value" => $user['nickname'],
                                    "color" => "#ffc0cb"
                                ],
                                "keyword2" => [
                                    "value" => "已签到！",
                                    "color" => "#173177"
                                ],
                                "keyword3" => [
                                    "value" => $db_user->score,
                                    "color" => "#173177"
                                ],
                                "keyword4" => [
                                    "value" => $today,
                                    "color" => "#173177"
                                ],
                            ]
                        ];
                        $tools->curl_post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
                    } else {
                        //未签到
                        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $tools->get_wechat_access_token();
                        $data = [
                            'touser' => $v,
                            'template_id' => "ulXe7l_78hvEU0gjlQSnPbFxi2kueNd-SYTH75EVNfU",
                            'data' => [
                                "keyword1" => [
                                    "value" => $user['nickname'],
                                    "color" => "#ffc0cb"
                                ],
                                "keyword2" => [
                                    "value" => "未签到！",
                                    "color" => "#173177"
                                ],
                                "keyword3" => [
                                    "value" => $db_user->score,
                                    "color" => "#173177"
                                ],
                                "keyword4" => [
                                    "value" => '',
                                    "color" => "#173177"
                                ],
                            ]
                        ];
                        $tools->curl_post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
                    }
                }
            }
            //每天没分钟发送一次
        })->cron('* * * * *');
        $schedule->call(function () {
            $tools = new Tools();
            \Log::info('测试任务调度');
            $news = $tools->redis->get('news');
            $redis = json_decode($news, 1);
            $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=" . $tools->get_wechat_access_token();
            $data = [
                'filter' => [
                    'is_to_all' => false,
                    'tag_id' => $redis['filter']['tag_id'],
                ],
                'text' => [
                    'content' => date('Y-m-d H:i:s', time()) . '：' . $redis['text']['content'],
                ],
                'msgtype' => 'text',
            ];
            $result = $tools->curl_post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
        })->cron('* * * * *');
        //每天八点发送
//        })->dailyAt('20:00');
        // $schedule->command('inspire')
        //          ->hourly();
//      }
        }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
