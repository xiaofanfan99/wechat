<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Tools\tools;
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
        $tools= new Tools();
        $schedule->call(function () {
            \Log::info('测试任务调度');
            $news=$this->tools->redis->get('news');
            $redis = json_decode($news,1);
            $url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$this->tools->get_wechat_access_token();
            $data=[
                'filter'=>[
                    'is_to_all'=>false,
                    'tag_id'=>$redis['filter']['tag_id'],
                ],
                'text'=>[
                    'content'=>$redis['text']['content'],
                ],
                'msgtype'=>'text',
            ];
            $result=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        })->daily();
        // $schedule->command('inspire')
        //          ->hourly();
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
