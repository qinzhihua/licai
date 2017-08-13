<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
class Uplan extends Controller
{
    public function uplan()
    {
        return $this->fetch('uplan');
    }
}