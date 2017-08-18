<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;//引入控制器
use app\common\helper\VerifyHelper;
use think\Session;
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
        $email = Db::query("SELECT email FROM userinfo WHERE id = 1");
        return $this->fetch('information',['email'=>$email]);
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
    /**
     * tp5邮件
     * @param
     * @author staitc7 <static7@qq.com>
     * @return mixed
     */
    public function email() {
        $rand = rand(5,9999);
        Session::set("rand",$rand);
        $toemail='893795936@qq.com';
        $name='人生几何 对酒当歌';
        $subject='久久贷 验证消息 请查收';
        $content='请在10分钟能添加验证码,验证码'.$rand;
        $result = send_mail($toemail,$name,$subject,$content);
        if($result==true)
        {
            echo 1;
        }
        else{
            echo 0;
        }
    }
    /**
     * 显示验证码图片
     */
    public function verify()
    {
        VerifyHelper::verify();
    }
    public function update()
    {
        return $this->fetch('update');
    }
    public function check_code(){
        $code = request()->post("code");
        $ressule = VerifyHelper::check($code);
        if($ressule=true)
        {
            echo 1;
        }
        else{
            echo 0;
        }
    }
    public function new_email()
    {

        $rand = Session::get('rand');
        if($rand=="")
        {
            $rand = "";
        }else{
            $rand = Session::get('rand');
        }
        return $this->fetch('new_email',['rand'=>$rand]);
    }
    public function new_email_do()
    {
        $new_email = $_POST['new_email'];
        if($new_email=="")
        {
            echo 0;
            exit();
        }

        $result =  Db::execute("update userinfo set email='$new_email' where id =1");
        if($result)
        {
            session::delete("rand");//清空sesson
            echo 1;
        }
        else{
            echo 0;
        }


    }
    public function resetpwd()
    {
        return $this->fetch('reset_pwd');
    }
    public function reset_do(){
        $new_pwd = $_POST['new_pwd'];
        $old_pwd = $_POST['old_pwd'];
        $old = Db::query("SELECT password FROM userinfo WHERE id = 1");
        $old = $old[0]['password'];
        if($old==$old_pwd)
        {
            $result =  Db::execute("update userinfo set password='$new_pwd' where id =1");
            if($result)
            {
                echo 1;
            }
            else{
                echo 0;
            }
        }
        else{
            echo 2;
        }

    }
}