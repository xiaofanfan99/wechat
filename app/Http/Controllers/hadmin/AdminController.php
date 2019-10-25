<?php

namespace App\Http\Controllers\hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //后台主页
    public function index()
    {
        return view('hadmin.admin.index');
    }
}
