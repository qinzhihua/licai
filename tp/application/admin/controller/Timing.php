<?php
namespace app\admin\controller;
use think\Controller; //使用控制器
use think\Db;
use think\Request;
use think\Session;
class Timing extends Controller{

function debx()  
{  
	$data = Db::table("order")->select();
	foreach($data as $key=>$val){
		$dkm     = $val['regular']; //贷款月数，20年就是240个月  
	    $dkTotal = $val['orderAmount']; //贷款总额  
	    $dknl    = $val['rate']/100;  //贷款年利率  
	    $emTotal = $dkTotal * $dknl / $dkm * pow(1 + $dknl / $dkm, $dkm) / (pow(1 + $dknl / $dkm, $dkm) - 1); //每月还款金额 
	    $lxTotal = 0; //总利息  
	    for ($i = 0; $i < $dkm; $i++) {  
	        $lx      = $dkTotal * $dknl / $val['regular'];   //每月还款利息  
	        $em      = $emTotal - $lx;  //每月还款本金  
	        echo "第" . ($i + 1) . "期", " 本金:", $em, " 利息:" . $lx, " 总额:" . $emTotal, "<br />";  
	        $dkTotal = $dkTotal - $em;  
	        $lxTotal = $lxTotal + $lx;  
	    }  
	    echo "总利息:" . $lxTotal.'<br/>'; 
	}
    
}  
  
  
function debj()  
{  
    $dkm     = 240; //贷款月数，20年就是240个月  
    $dkTotal = 10000; //贷款总额  
    $dknl    = 0.0515;  //贷款年利率  
       
    $em      = $dkTotal / $dkm; //每个月还款本金  
    $lxTotal = 0; //总利息  
    for ($i = 0; $i < $dkm; $i++) {  
        $lx      = $dkTotal * $dknl / 12; //每月还款利息  
        echo "第" . ($i + 1) . "期", " 本金:", $em, " 利息:" . $lx, " 总额:" . ($em + $lx), "<br />";  
        $dkTotal -= $em;  
        $lxTotal = $lxTotal + $lx;  
    }  
    echo "总利息:" . $lxTotal;  
}   
}
