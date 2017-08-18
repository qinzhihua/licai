<?php
namespace app\admin\controller;
use think\Controller;
use think\Db; //使用控制器

//use think\View;

class Uplan extends Controller
{
    public function uplan()
    {

        $res = $this->sel();


//        $a = '12.3';
//        echo (".3f",$a);//将输出  12.300
//$num=9.8;
//$res=sprintf("%.1f", $num);
//        echo $res;
//        $a=1;
//        echo(round($a,2));
//        echo(number_format(1.1,1));
//        $a = 10.2;
//       echo (".3f",123);die;
//        print_r($res);
//        var_dump($res);
//        die;
//        $this->assign('res',$res);
//        sprintf("%.1f", $num)


        return view('uplan',['res'=>$res]);
    }

    public function sel(){
        $res = Db::table('productinfo')->where('productTypeId','1')->select();
        return $res;
    }

    public function u1(){
        return view('u1');
    }


    public function add(){
//        echo 1;die;
        $price = Input("get.price");
        $id = Input("get.id");

        $data = Db::table("productinfo")->where("id",$id)->find();
//        print_r($);die;
        $info['price'] = $price;
        $info['money'] = $price *$data['deadline'];
//        echo 1;
        echo $this->getHtml($data,$info);
    }

    public function getHtml($taday_salaryplan_list,$data)
    {
        return $res = '<div class="autoinvest-buy-main" style="display: block;">
                <div class="autoinvest-shadow"></div>
                <div class="autoinvest-buy-form" style="top: 0px;">
            <div class="form-header">
                <span class="form-title">支付</span>
                <span class="dialog-close-btn J-autoinvest-close">×</span>
            </div>
            <div class="form-content">
                <div class="pay-form">
            <div class="name"><span class="l-title">计划名称</span> <span class="text-value">'.$taday_salaryplan_list['product_name'].'</span></div>
            <div class="rate"><span class="l-title">预期年化利率</span> <span class="text-value">'.sprintf("%.2f",$taday_salaryplan_list['rate']).'%</span></div>
            <div class="method"><span class="l-title">收益处理</span> <span class="text-value">收益再投资</span></div>
            <div class="limit"><span class="l-title">理财期限</span> <span class="text-value invest-limit">'.$taday_salaryplan_list['deadline'].'个月</span></div>
            <div class="amount"><span class="l-title">月投资金额</span> <span class="text-value invest-money" data-invest-money="5500">'.$data['price'].'元</span></div>
            <div class="amount"><span class="l-title">总投资金额</span> <span class="text-value total-invest-money">'.$taday_salaryplan_list['amount'].'元</span></div>
            <div class="coupon fn-clear" id="coupon">
            <div class="coupon-component" data-reactid=".3">
            <div class="coupon-left" data-reactid=".3.0"><span class="l-title">优惠劵</span></div>
            <div class="coupon-right" data-reactid=".3.1">
            <div class="coupon-one-line" data-reactid=".3.1.0"><span data-reactid=".3.1.0.0"></span><span data-reactid=".3.1.0.1"></span></div>
            <!-- <div class="j_gray_packet_tips " data-reactid=".3.1.1">本次投资可抵扣元</div> --><span data-reactid=".3.1.2"></span><div class="coupon-error" data-reactid=".3.1.3"></div></div></div></div>

            <div class="invest-d"><span class="l-title">每月投资日</span> <span class="text-value invest-date">每月'.substr($taday_salaryplan_list['invest_time'],-2).'号</span></div>
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