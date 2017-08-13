<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
class Borrow extends Controller
{
    public function borrow()
    {
        return $this->fetch('borrow');
    }


}