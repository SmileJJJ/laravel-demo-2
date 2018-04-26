<?php

namespace App\Http\Controllers;


use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Mail;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    //

    public function queue()
    {
        $this->dispatch(new SendEmail('281206814@qq.com')); 
    }

    public function error()
    {
      //  $name='shen';
      //  var_dump($name);
        Log::info('这是一个info级别的日志');
        Log::warning('这是一个warning级别的日志');

    }

    public function cache1()
    {
        //put()
        //Cache::put('key1','val1',10);

        //add()
        //$bool=Cache::add('key2','val2',10);
        //var_dump($bool);

        //forever() 永久保存
        //Cache::forever('key3','val3');

        //has()
        if(Cache::has('key2'))
        {
            $val=Cache::get('key2');
            var_dump($val);
        }
        else
        {
            echo 'NO';
        }

    }

    public function cache2()
    {
        //get()
        //$val=Cache::get('key3');

        //pull()
//        $val=Cache::pull('key1');
//        var_dump($val);

        //forget
        $bool=Cache::forget('key3');
        var_dump($bool);
    }

    public function mail()
    {
//        Mail::raw('邮件内容 测试',function($message){
//            $message->from('2014896347@qq.com','南明离火');
//            $message->subject('邮件主题 测试');
//            $message->to('281206814@qq.com');
//        });

        Mail::send('student.mail',['name'=>'nanxi'],function ($message){
            $message->subject('邮件主题 测试');
            $message->from('2014896347@qq.com','南明离火');
            $message->to('281206814@qq.com');
        });
    }


    public function upload(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $file=$request->file('source');
            //文件是否上传成功
            if($file->isValid())
            {
               //原文件名
               $originalName=$file->getClientOriginalName();
               //扩展名
               $ext=$file->getClientOriginalExtension();
               //MimeType
               $type=$file->getClientMimeType();
               //临时绝对路径
               $realPath=$file->getRealPath();

               $filename =date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;

               $bool=Storage::disk('uploads')->put($filename,file_get_contents($realPath));
               var_dump($bool);
            }
            exit;
        }
        return view('student.upload');
    }
}
