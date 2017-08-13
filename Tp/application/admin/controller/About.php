<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
class About extends Controller
{
    public function about()
    {
        return $this->fetch('about');
    }


}