<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
class Login extends Controller
{
    public function login()
    {
        return $this->fetch('login');
    }
    public function regist()
    {
        return $this->fetch('regist');
    }


}