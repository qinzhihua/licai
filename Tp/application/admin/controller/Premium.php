<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
class Premium extends Controller
{
    public function premium()
    {
        return $this->fetch('premium');
    }


}