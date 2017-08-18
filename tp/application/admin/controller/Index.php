<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
class Index extends Controller
{
    public function index()
    {
        return $this->fetch('index');
    }
    public function index_1()
    {
        return $this->fetch("index_1");
    }
    public function index_2()
    {
        return $this->fetch("index_2");
    }
    public function index_3()
    {
        return $this->fetch("index_3");
    }


}