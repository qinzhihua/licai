<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
use think\Db;
use think\Request;
use think\Session;
class Autoinvest extends Controller
{
    //设置默认用户
	public function session(){
        $data = Db::table("userinfo")->where("id",1)->find();
        session::set("user",$data);
//         session::delete("user");
	}
 
   //薪计划定时计划
   public function timingPlan(){
       
   }

   //薪计划
    public function autoinvest()
    {
    	//查询本期薪计划信息
    	$data = Db::table("productinfo")->where("productTypeId",'3')->order("productName desc")->find();
    	//查询加入记录
    	$res = Db::table('userorderlog')->alias('a')->join('userinfo w','a.userid = w.id')->join('productinfo c','a.productId = c.id')->select();
    	$expiration = date("Y年m月d日",$data['investTime']+3600*24*365);
    	//查询历史期数与收益
    	$dataAll = Db::table("productinfo")->where("productTypeId",'3')->order("productName desc")->select();
    	$userInfo = session::get("user");
    	$this->assign('expiration',$expiration);
    	$this->assign('data',$data);
    	$this->assign('dataAll',$dataAll);
    	$this->assign('res',$res);
    	$this->assign('userInfo',$userInfo);
        return $this->fetch('autoinvest');
    }

  /**
   * 调用支付页面
   */
   public function add(){
     $price = Input("get.price");
     $id = Input("get.id");
     $data = Db::table("productinfo")->where("id",$id)->find();
     $info['price'] = $price;
     $info['money'] = $price *$data['deadline'];
     $res = session::get("user");
     //判断是否有余额
     if(empty($res)){
     	echo 1;
     }else{
     	 echo $this->getHtml($data,$info);
     }
    
   }

/**
 * 验证余额并支付
 */
   public function code(){
   	 $price = Input("get.price");
     $id = Input("get.id");
     $productId = Input("get.productId");
       $type = Input("get.type");
     //读取用户信息
     $data = Db::table("userinfo")->where("id",$id)->find();

	 //判断是否实名认证
       if($data['authstatus']==1){
       //判断是否有余额
           if($price>$data['money']){
               echo 1;   //余额不足
           }else{
               $productInfo = Db::table("productinfo")->where("id",$productId)->find();
               $newMan = $productInfo['actualInvestment']+1;
               //判断产品购买人数
               if($newMan>$productInfo['plannedInvestment']){
                   echo 4;     //购买名额已满
               }else{
                   $phone = substr($data['telephone'],-4);   //截取手机号后四位
                   $time = time();
                   if($type=='1'){
                       $order_id = '123'.$time.$phone;      //生成关于U计划的订单号
                   }else if($type=='2'){
                       $order_id = '475'.$time.$phone;   //生成关于优选计划的订单号
                   }else if($type=='3'){
                       $order_id = '698'.$time.$phone;   //生成关于薪计划的订单号
                   }

                   $interestEndTime = $productInfo['investTime']+3600*24*365;
                   $newMoney = $data['money']-$price;     //支付后的账户余额
                   //订单数据
                   $dataInfo = ['order_id'=>$order_id,"userid"=>$data['id'],"productId"=>$productInfo['id'],"orderAmount"=>$price,"paytime"=>$time,"addtime"=>$time,"orderStatus"=>2,"interestTime"=>$productInfo['investTime'],"regular"=>$productInfo['deadline'],"interestEndTime"=>$interestEndTime,"rate"=>$productInfo['rate']];
                   echo json_encode($dataInfo);
                 /*  //添加订单
                   $res = Db::table("order")->insert($dataInfo);
                   if($res){
                       //修改产品购买人数
                       Db::table("productinfo")->where("id",$productInfo['id'])->update(['actualInvestment'=>$newMan]);
                       //修改用户余额
                       Db::table("userinfo")->where("id",$data['id'])->update(["money"=>"$newMoney"]);
                       //修改session数据
                       $user = Db::table("userinfo")->where("id",$data['id'])->find();
                       session::set("user",$user);
                       echo 2;    //支付成功
                   }else{
                       echo 3;    //支付失败
                   }*/
               }

           }
       }else{
           echo 5;  //未实名
       }

   }

   public function getHtml($list,$info)
    {   
    	$user = session::get("user");
        return $res = '<div class="autoinvest-buy-main" style="display: block;">
                <div class="autoinvest-shadow"></div>
                <div class="autoinvest-buy-form" style="top: 0px;">
            <div class="form-header">
                <span class="form-title">支付</span>
                <input type="hidden" value="'.$user['id'].'" id="userId"/>
                <span class="dialog-close-btn J-autoinvest-close">×</span>
            </div>
            <div class="form-content">
                <div class="pay-form">
            <div class="name"><span class="l-title">计划名称</span> <span class="text-value">薪计划'.$list['productName'].'期</span></div>
            <div class="rate"><span class="l-title">预期年化利率</span> <span class="text-value">'.sprintf("%.2f",$list['rate']).'%</span></div>
            <div class="method"><span class="l-title">收益处理</span> <span class="text-value">收益再投资</span></div>
            <div class="limit"><span class="l-title">理财期限</span> <span class="text-value invest-limit">'.$list['deadline'].'个月</span></div>
            <div class="amount"><span class="l-title">月投资金额</span> <span class="text-value invest-money" data-invest-money="5500"><span id="price">'.$info['price'].'</span>元</span></div>
            <div class="amount"><span class="l-title">总投资金额</span> <span class="text-value total-invest-money">'.$info['money'].'元</span></div>
            <div class="coupon fn-clear" id="coupon">
            <div class="coupon-component" data-reactid=".3">
            <div class="coupon-left" data-reactid=".3.0"><span class="l-title">优惠劵</span></div>
            <div class="coupon-right" data-reactid=".3.1">
            <div class="coupon-one-line" data-reactid=".3.1.0"><span data-reactid=".3.1.0.0"></span><span data-reactid=".3.1.0.1"></span></div>
            <!-- <div class="j_gray_packet_tips " data-reactid=".3.1.1">本次投资可抵扣元</div> --><span data-reactid=".3.1.2"></span><div class="coupon-error" data-reactid=".3.1.3"></div></div></div></div>

            <div class="invest-d"><span class="l-title">每月投资日</span> <span class="text-value invest-date">每月'.substr($list['productName'],-2).'号</span></div>
            <div class="real-money"><span class="l-title">应付金额</span> <span class="text-value actual-price" data-actual-money="5500">'.$info['price'].'元</span></div>
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