<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
class Autoinvest extends Controller
{
    public function autoinvest()
    {
        return $this->fetch('autoinvest');
    }


}