<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
use think\Db;
use think\Session;
class Login extends Controller
{
    public function login()
    {
    	if($post = input('post.')){
    		$username = $post['j_username'];
    		$password = $post['j_password'];
    		$user_id = Db::table('userinfo')->where('telephone|email',$username)->find()['id'];
    		if($user_id){
    			Session::set('user_id',$user_id);
    			$this->success('登录成功', 'index/index', 2);
    		}else{
    			$this->error('登录失败');
    		}
    		echo $user_id;
    	}else{
    		return $this->fetch('login',['lORr'=>0]);
    	}
    }

    public function regist()
    {
        if($post = input('post.')){
        	$addData = array(
        		'username'  => 'RRZ' . time(),
        		'telephone' => $post['phone'],
        		'password'  => md5($post['password']),
        		'regtime'   => time(),
        		'level'     => $this->password_level($post['password'])
        	);
        	$res = Db::execute('insert into userinfo (username, telephone, password, regtime, level) values (:username, :telephone, :password, :regtime, :level)',$addData);
        	if($res){
        		$user_id = Db::getLastInsID();
        		Session::set('user_id',$user_id);
        		$this->success('注册成功', 'index/index', 2);
        	}else{
        		$this->error('注册失败');
        	}
        }else{
        	return $this->fetch('login',['lORr'=>'1']);
        }
    }

    public function checkUAndP(){
    	$username = input('get.username');
    	$password = md5(input('get.password'));
    	$type = input('get.type');
    	if($type == 1){
    		$is_u = Db::table('userinfo')->where('telephone',$username)->find();
    		if(!empty($is_u)){
    			$is_u_p = Db::table('userinfo')->where('telephone',$username)->where('password',$password)->find();
    			if(!empty($is_u_p)){
    				return 1;
    			}else{
    				return "用户名密码不正确"; //用户名密码不正确
    			}
    		}else{
    			return "用户名不存在"; //用户名不存在
    		}
    	}else{
			$is_u = Db::table('userinfo')->where('email',$username)->find();
			if(!empty($is_u)){
    			$is_u_p = Db::table('userinfo')->where('email',$username)->where('password',$password)->find();
    			if(!empty($is_u_p)){
    				return 1;
    			}else{
    				return "用户名密码不正确"; //用户名密码不正确
    			}
    		}else{
    			return "用户名不存在"; //用户名不存在
    		}
    	}
    }

    public function checkCaptcha()
    {
    	$captcha = input('get.captcha');
    	if(!captcha_check($captcha)){
    		return -1;
    	}else{
    		return 1;
    	}
    }

    public function sendInfo()
    {
    	$phone = input('get.phone');
    	$code = "";  
        for($i=0;$i<4;$i++){  
            $code .= rand(0,9);  
        } 
    	$url = 'http://api.k780.com/?app=sms.send&tempid=51108&param=code%3D'.$code.'&phone='.$phone.'&appkey=23903&sign=6cc2c3422238a4bb15c0f0dc55798950&format=json';
    	$result = file_get_contents($url);
    	$arr = json_decode($result, true);
    	if($arr['success'] == 1){
    		return $code;
    	}else{
    		return false;
    	}
    }

    public function password_level($password){

        if(preg_match('/^([0-9]{8,16})$/',$password)){

            return 0;

        }else if(preg_match('/^[0-9 a-z]{8,16}$/',$password)){

            return 1;

        }else if(preg_match('/^[0-9 a-z A-Z !@#$%^&*]{8,16}$/',$password)){

            return 2;

        }

        return 0;

    }


}