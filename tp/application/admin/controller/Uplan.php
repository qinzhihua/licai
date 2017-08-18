<?php
namespace app\admin\controller;
use think\Controller;
use think\Db; //使用控制器
use \think\Session;
//use think\View;

class Uplan extends Controller
{
    public function uplan()
    {
        $res = $this->sel();
        $userInfo = session::get("user");
        $this->assign("userInfo",$userInfo);
        $this->assign("res",$res);
        return $this->fetch("uplan");
    }

    public function sel(){
        $res = Db::table('productinfo')->where('productTypeId','1')->select();
        return $res;
    }

    public function info()
    {
        $id = Input('id');//后面要用替换1
        $res = Db::table('productinfo')->where('id',$id)->find();
        $res['time'] = time();
        $amount = Db::query("select count(userid) as cou,sum(orderAmount) as amo from `order` where productId = 2");
        $res['amo'] = $amount[0]['amo'];
        $res['cou'] = $amount[0]['cou'];
        $userInfo = session::get("user");
        $this->assign("userInfo",$userInfo);
        $this->assign('data',$res);
        return $this->fetch('info');
    }



    public function add(){
        $price = Input("get.price");
        $id = Input("get.id");
        $data = Db::table("productinfo")->where("id",$id)->find();
        $info['price'] = $price;
        $info['money'] = $price *$data['deadline'];
        $user = session::get("user");
        if(empty($user)){
            echo 1;
        }else{
            echo $this->getHtml($data,$info);
        }

    }

    public function getHtml($taday_salaryplan_list,$data)
    {
        $user = session::get("user");
        return $res = '<div class="autoinvest-buy-main" style="display: block;">
                <div class="autoinvest-shadow"></div>
                <div class="autoinvest-buy-form" style="top: 0px;">
            <div class="form-header">
                <span class="form-title">支付</span>
                <input type="hidden" value="'.$user['id'].'" id="userId"/>
                <span class="dialog-close-btn J-autoinvest-close" id="non">×</span>
            </div>
            <div class="form-content">
                <div class="pay-form">
            <div class="name"><span class="l-title">计划名称</span> <span class="text-value">'.$taday_salaryplan_list['productName'].'</span></div>
            <div class="rate"><span class="l-title">预期年化利率</span> <span class="text-value">'.sprintf("%.2f",$taday_salaryplan_list['rate']).'%</span></div>
            <div class="method"><span class="l-title">加入金额</span> <span class="text-value">收益再投资</span></div>
            <div class="limit"><span class="l-title">投资期限</span> <span class="text-value invest-limit">'.$taday_salaryplan_list['deadline'].'个月</span></div>
            <div class="amount"><span class="l-title">月投资金额</span> <span class="text-value invest-money" data-invest-money="5500"><span id="price">'.$data['price'].'</span>元</span></div>
            <div class="coupon fn-clear" id="coupon">
            <div class="coupon-component" data-reactid=".3">
            <div class="coupon-right" data-reactid=".3.1">
            <div class="coupon-one-line" data-reactid=".3.1.0"><span data-reactid=".3.1.0.0"></span><span data-reactid=".3.1.0.1"></span></div>
            <!-- <div class="j_gray_packet_tips " data-reactid=".3.1.1">本次投资可抵扣元</div> --><span data-reactid=".3.1.2"></span><div class="coupon-error" data-reactid=".3.1.3"></div></div></div></div>

            <div class="invest-d"><span class="l-title">每月投资日</span> <span class="text-value invest-date">每月'.substr($taday_salaryplan_list['investTime'],-2).'号</span></div>
            <div class="real-money"><span class="l-title">应付金额</span> <span class="text-value actual-price" data-actual-money="5500">'.$data['price'].'元</span></div>
            <div class="agreement"><i class="icon-we-gouxuanicon"></i>我已阅读并同意签署<a href="/autoinvestplan/autoInvestPlanContract.action?autoInvestPlanId=20569" target="_blank">《薪计划170815期服务协议书》</a>及<a href="https://www.renrendai.com/pc/agreement/contract/currency/cmsId/58ec7c0d090cc9096532d0ca" target="_blank">《风险提示》</a></div>
        </div>
        </div>
            <div class="form-footer">
                <div class="submit J-autoinvest-submit">确定</div><div class="add-tip">
                        <div class="title">温馨提示</div>
                        <div class="msg">1、月投资日、月投资金额由加入时确定, 后续月份不支持修改。</div>
                        <div class="msg">2、为避免延期, 请每月提前充值至账户, 系统达到每月投资日自动划扣。</div>
                        <div class="msg">3、本计划不支持提前退出。</div>
                        <div class="msg">4、预期年化利率不代表实际收益。</div>
                    </div>
            </div>
        </div></div>';
    }



}