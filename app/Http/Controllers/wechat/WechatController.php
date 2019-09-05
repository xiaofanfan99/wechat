<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    public function upload()
    {
        return view('wechat/upload');
    }

    public function do_upload()
    {
        $images=request()->file('images');
        // dd($images);
        $name='images';
        if(request()->hasFile($name) && request()->file($name)->isValid()){
            $photo = request()->file($name)->store('wechat');
            dd($photo);
        }
    }
}
