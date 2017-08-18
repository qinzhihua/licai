<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;//引入控制器
class Account extends Controller
{
    public function account()
    {
        $money = Db::query("select id,money from userinfo where id = 1 ");
        return $this->fetch('account',['money'=>$money]);
    }
    public function bank()
    {
        $money = Db::query("select id,money from userinfo where id = 1 ");

        return $this->fetch('bank',['money'=>$money]);
    }
    public function news()
    {
        $news = Db::query("select * from message order by time desc limit 2");
        return $this->fetch('news',['news'=>$news]);
    }
    public function information()
    {
        return $this->fetch('information');
    }
    public function alipay()
    {

    }
    public function privilege()
    {
        $user_id = 1;
        $user = Db::query("select Coupon from userinfo where  id=$user_id");
        $id = $user[0]['Coupon'];
        $result = Db::query("select * from Coupon where  Couponid in($id)");
        $url = "http://www.jin.com/ShiXun/licai/Tp/public/admin/login/regist/id/1";
        return $this->fetch('privilege',['result'=>$result]);
    }


}