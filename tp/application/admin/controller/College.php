<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
class College extends Controller
{
    public function college()
    {
        return $this->fetch('college');
    }


}