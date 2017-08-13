<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
class Account extends Controller
{
    public function account()
    {
        return $this->fetch('account');
    }


}