<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
use think\Db;
use think\Request;
use think\Session;
class Index extends Controller
{
    public function index()
    {
    	$userInfo = session::get("user");
    	//查询优选计划信息
    	$premiumInfo = Db::table("productinfo")->where("productTypeId",2)->limit(1)->order("investTime desc")->find();
    	//查询U计划信息
    	$accountInfo = Db::table("productinfo")->where("productTypeId",1)->limit(5)->order("deadline asc")->select();
    	//查询薪计划信息
    	$autoinvestInfo = Db::table("productinfo")->where("productTypeId",3)->limit(1)->order("investTime desc")->find();
    	$this->assign("autoinvestInfo",$autoinvestInfo);
    	$this->assign("accountInfo",$accountInfo);
    	$this->assign("premiumInfo",$premiumInfo);
    	$this->assign("userInfo",$userInfo);
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