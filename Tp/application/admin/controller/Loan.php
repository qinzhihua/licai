<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
class Loan extends Controller
{
    public function loan()
    {
        return $this->fetch('loan');
    }


}