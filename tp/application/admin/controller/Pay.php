<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
use  app\admin\model\Submit;
use  app\admin\model\Corefunction;
use  app\admin\model\Md5function;
use  app\admin\model\Notify;
use  app\admin\model\Config;
use think\Db;//引入控制器
use think\Session;//引入控制器

class pay extends Controller
{
    public function pay(){
        vendor('Alipay.Corefunction');
        vendor('Alipay.Md5function');
        vendor('Alipay.Notify');
        vendor('Alipay.Submit');
        $out_trade_no = $_POST['WIDout_trade_no'];//订单名称，必填
        $subject = $_POST['WIDsubject'];///商品描述，可空
        $total_fee = $_POST['WIDtotal_fee'];//付款金额，必填
        $body = $_POST['WIDout_trade_no'];
        $config = new Config();
        $alipay_config = $config->alipay_config();
        $parameter = $config->parameter();
        $parameter['out_trade_no'] = $out_trade_no;
        $parameter['subject'] = $subject  ;
        $parameter['total_fee'] = $total_fee  ;
        $parameter['body'] = $body;
        session::set("money",$total_fee);//将金额存入session
        $alipaySubmit = new Submit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");

        return $html_text;
    }
    public function notify_url(){
        $config = new Config();
        $alipay_config = $config->alipay_config();
        $alipayNotify = new Notify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {//验证成功
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            if($_POST['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处
            }
            echo "success";		//请不要修改或删除
        }
        else {
            //验证失败
            echo "fail";
          /*  调试用，写文本函数记录程序运行情况是否正常
            logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");*/
        }
        return $this->fetch('autoinvest');
    }
    public function return_url(){
        $config = new Config();
        $alipay_config = $config->alipay_config();
        $alipayNotify = new Notify($alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        if($verify_result) {//验证成功
            //商户订单号
            $out_trade_no = $_GET['out_trade_no'];
            //支付宝交易号
            $trade_no = $_GET['trade_no'];
            //交易状态
            $trade_status = $_GET['trade_status'];
            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
            }
            else {
                echo "trade_status=".$_GET['trade_status'];
            }
            $total_fee = session::get("money");
            Db::execute("update userinfo set money= money+$total_fee where id =1");
            session::delete("money");//清空sesson
            echo "<script>location.href='http://www.shixun.com/public/admin/account/bank'</script>";
        }
        else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo "<script>location.href='http://www.shixun.com/public/admin/account/bank'</script>";
        }

    }
}