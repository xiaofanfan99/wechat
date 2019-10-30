<?php

namespace App\Http\Controllers\api;

use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Model\api\Student;
use App\Model\api\Clas;
use phpDocumentor\Reflection\DocBlock\Tag\VarTag;

class StudentController extends Controller
{
    /**
     * 班级展示列表
     */
    public function class_list()
    {
//        echo "<pre>";
        //查看学生班级
        $class_data=Clas::get()->toarray();
        //根据学生表查询班级学生人数
        foreach ($class_data as $key=>$value){
            $student_count = Student::where(['class_id'=>$value['class_id']])->count();
            $class_data[$key]['student_count']=$student_count;
        }
        return view('api/student/class_list',['class_data'=>$class_data]);
    }

    /**
     * 班级学生展示列表
     */
    public function class_student_list()
    {
//        echo "<pre>";
        //查询班级信息
        $class_data=Clas::get()->toArray();
        //根据班级查询学生信息
        foreach ($class_data as $key=>$value){
            $student_data = Student::where(['student.class_id'=>$value['class_id']])->get()->toArray();
           $class_data[$key]['studentData']=$student_data;
        }
//        var_dump($class_data);
       return view('api/student/class_student_list',['class_data'=>$class_data]);
    }
}
