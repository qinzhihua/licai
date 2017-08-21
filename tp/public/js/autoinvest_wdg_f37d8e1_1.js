;/*!/client/widget/product/detail/join-record/list/list.js*/
define("autoinvest:widget/product/detail/join-record/list/list.js",function(require,exports,module){function _classCallCheck(instance,Constructor){if(!(instance instanceof Constructor))throw new TypeError("Cannot call a class as a function")}function _inherits(subClass,superClass){if("function"!=typeof superClass&&null!==superClass)throw new TypeError("Super expression must either be null or a function, not "+typeof superClass);subClass.prototype=Object.create(superClass&&superClass.prototype,{constructor:{value:subClass,enumerable:!1,writable:!0,configurable:!0}}),superClass&&(Object.setPrototypeOf?Object.setPrototypeOf(subClass,superClass):subClass.__proto__=superClass)}var React=require("common:node_modules/react/react"),moment=(require("common:node_modules/react-dom/index"),require("common:node_modules/moment/moment")),numeral=require("common:node_modules/numeral/numeral"),JoinRecord=function(_React$Component){function JoinRecord(props){_classCallCheck(this,JoinRecord),_React$Component.call(this,props)}return _inherits(JoinRecord,_React$Component),JoinRecord.prototype.render=function(){var list=this.props.data.map(function(item,index){var createTime=moment(item.createTime).format("YYYY年MM月DD日 HH:mm"),amount=numeral(item.amount).format("0,0");return React.createElement("div",{className:index%2!=0?"data-list fn-clear":"data-list fn-clear odd",key:index},React.createElement("div",{className:"d-index"},index+1),React.createElement("div",{className:"d-name"},item.nickName),React.createElement("div",{className:"d-invest-money"},amount),React.createElement("div",{className:"d-source"},"PC"==item.tradeMethod?React.createElement("i",{className:"icon-we-diannaoicon"}):React.createElement("i",{className:"icon-we-shoujiicon"})),React.createElement("div",{className:"d-join-time"},createTime))});return React.createElement("div",null,list.length>0?list:React.createElement("div",{className:"list-no-data-text"},"暂无加入记录"))},JoinRecord}(React.Component);module.exports=JoinRecord});
;/*!/client/widget/product/detail/pay-popup/pay-popup.js*/
define("autoinvest:widget/product/detail/pay-popup/pay-popup.js",function(require,exports,module){var React=require("common:node_modules/react/react"),ReactDOM=require("common:node_modules/react-dom/index"),RCoupon=require("common:widget/react-ui/RCoupon/RCoupon"),$=require("common:widget/lib/jquery/jquery"),numeral=require("common:node_modules/numeral/numeral"),obj=function(){var AutoinvestPayWindow=function(){var options=arguments[0]||{};this.type=options.type,this.data=options.data,this.id=options.id,this.submit=options.submitCallback,this.cancel=options.cancelCallback,this.modal=createModal.call(this),initializeEvents.call(this)};AutoinvestPayWindow.prototype.show=function(){this.modal.style.display="block",modifyTemplateStyle(this.id)},AutoinvestPayWindow.prototype.hide=function(){this.modal.style.display="none",this.modal.parentNode.removeChild(this.modal),this.modal=null};var createModal=function(){var oDiv=document.createElement("div");oDiv.className="autoinvest-buy-main",this.id&&(oDiv.id=this.id),oDiv.innerHTML=createTemplate(this.type,this.data);var root=document.getElementsByTagName("body")[0];return root.appendChild(oDiv),oDiv},createTemplate=function(type,data){var config=templateConfig(type),title=config.title||data.title,tpl=config.tpl(data),buttonGroup=footerButtonGroup(type,data);return'\n                <div class="autoinvest-shadow"></div>\n                <div class="autoinvest-buy-form">\n                    <div class="form-header">\n                        <span class="form-title">'+title+'</span>\n                        <span class="dialog-close-btn J-autoinvest-close">×</span>\n                    </div>\n                    <div class="form-content">\n                        '+tpl+'\n                    </div>\n                    <div class="form-footer">\n                        '+buttonGroup+"\n                    </div>\n                </div>\n            "},warningTemplate=function(data){var nickname=data.nickname,msg=data.msg;return'<div class="popup-unpay-wrap">\n                    <div class="tip-icon icon-we-failed"></div>\n                    <div class="popup-unpay-text">\n                        <p>尊敬的'+nickname+": </p>\n                        <p>"+msg+"</p>\n                    </div>\n                </div>"},payCurrentPeriodTemplate=function(data){var total=numeral(data.amount*data.period).format("0,0"),rate=data.rate.toFixed(2),amount=numeral(data.amount).format("0,0");return'<div class="pay-form">\n                    <div class="name"><span class="l-title">计划名称</span> <span class="text-value">'+data.name+'</span></div>\n                    <div class="rate"><span class="l-title">预期年化利率</span> <span class="text-value">'+rate+'%</span></div>\n                    <div class="method"><span class="l-title">收益处理</span> <span class="text-value">收益再投资</span></div>\n                    <div class="limit"><span class="l-title">理财期限</span> <span class="text-value invest-limit">'+data.period+'个月</span></div>\n                    <div class="amount"><span class="l-title">月投资金额</span> <span class="text-value invest-money" data-invest-money="'+data.amount+'">'+amount+'元</span></div>\n                    <div class="amount"><span class="l-title">总投资金额</span> <span class="text-value total-invest-money">'+total+'元</span></div>\n                    <div class="coupon fn-clear" id="coupon"><span class="l-title">优惠券</span> <span class="text-value"></span></div>\n                    <div class="invest-d"><span class="l-title">每月投资日</span> <span class="text-value invest-date">每月'+data.investDay+'号</span></div>\n                    <div class="real-money"><span class="l-title">应付金额</span> <span class="text-value actual-price" data-actual-money="'+data.amount+'">'+amount+'元</span></div>\n                    <div class="agreement"><i class="icon-we-gouxuanicon"></i>我已阅读并同意签署<a href="/autoinvestplan/autoInvestPlanContract.action?autoInvestPlanId='+data.autoinvestId+'" target="_blank">《'+data.name+'服务协议书》</a>及<a href="https://www.renrendai.com/pc/agreement/contract/currency/cmsId/58ec7c0d090cc9096532d0ca" target="_blank">《风险提示》</a></div>\n                </div>'},normalTemplate=function(data){var tpl="";return data.success&&(tpl='<div class="normal-popup-tip-icon icon-we-success"></div>'),tpl+='<div class="normal-popup-text">尊敬的'+data.nickname+": "+data.text+"</div>",data.success&&(tpl+='<div class="normal-success"><p>邀请好友投资, 您与好友各得1%加息券,</p><p>多邀多得, 快快<a href="/pc/event/invitefriends/invitefriends">邀请壕友</a>。</p></div>'),tpl},continueJoinTemplate=function(data){var nickname=data.nickname,count=data.count,day=data.day;return'<div class="simple-popup-tpl">\n                    <div class="title">尊敬的'+nickname+':</div>\n                    <div class="msg">\n                        <p>您有'+count+"期支付日为每月"+day+"日的薪计划。</p>\n                        <p>您需要在每月"+day+"日再额外加入一期薪计划吗?</p>        \n                    </div>\n                </div>"},footerButtonGroup=function(type){var buttonGroup='<div class="submit J-autoinvest-submit">确定</div>';return"PAY"==type&&(buttonGroup+='<div class="add-tip">\n                                <div class="title">温馨提示</div>\n                                <div class="msg">1、月投资日、月投资金额由加入时确定, 后续月份不支持修改。</div>\n                                <div class="msg">2、为避免延期, 请每月提前充值至账户, 系统达到每月投资日自动划扣。</div>\n                                <div class="msg">3、本计划不支持提前退出。</div>\n                                <div class="msg">4、预期年化利率不代表实际收益。</div>\n                            </div>'),buttonGroup},templateConfig=function(modalType){var tplMap={WARN:{tpl:warningTemplate,title:"提示"},PAY:{tpl:payCurrentPeriodTemplate,title:"支付",initEvent:getCouponEvent},NORMAL:{tpl:normalTemplate},INFO:{tpl:continueJoinTemplate,title:"提示"}};return tplMap[modalType]},initializeEvents=function(){var _this=this,submitBtn=$(".J-autoinvest-submit"),closeBtn=[$(".J-autoinvest-cancel"),$(".J-autoinvest-close")];submitBtn.on("click",function(){if(-1!=_this.type.indexOf("PAY")){if($(".autoinvest-buy-form .agreement").find("i").hasClass("icon-we-weigouxuanicon")){$(".autoinvest-buy-form .agree-tip").remove();var tip=$('<div class="agree-tip">投标前请阅读并同意协议</div>');return $(".autoinvest-buy-form .pay-form").append(tip),!1}var payMoney=$(".autoinvest-buy-form .actual-price").data("actual-money");if(payMoney>_this.data.dueAccountMoney){var oParent=$(".autoinvest-buy-form .pay-form");if(!oParent.hasClass("disable-pay")){var tip=$("<span class=\"due-tip\">您的余额不足  　<a href='/pc/user/trade/recharge'>充值</a></span>");$(".autoinvest-buy-form .pay-form").append(tip),oParent.addClass("disable-pay")}return!1}}_this.submit&&_this.submit(_this.data),_this.hide()}),closeBtn.forEach(function(item){item.on("click",function(){_this.cancel&&_this.cancel(),_this.hide()})});var tplConf=templateConfig(_this.type);tplConf.initEvent&&tplConf.initEvent(_this.data)},getCouponEvent=function(data){function selectCallback(id,list){var investDom=$(".autoinvest-buy-form .invest-money"),investMoney=parseInt(investDom.data("invest-money")),priceDom=$(".autoinvest-buy-form .actual-price");id?list.forEach(function(item){if(id==item.couponId){var actualPrice=investMoney-item.couponValue;priceDom.html(numeral(actualPrice).format(",0.00")+"元"),priceDom.data("coupon-id",id),priceDom.data("actual-money",actualPrice),data.couponId=priceDom.data("coupon-id")}}):(priceDom.html(numeral(investMoney).format(",0.00")+"元"),priceDom.data("actual-money",investMoney),priceDom.removeData("coupon-id"),data.couponId=null)}var queryCoupon={businessCategory:"AUTO_INVEST_PLAN",payAmount:data.amount,bindScene:1};$.ajax({url:"/pc/transfer/detail/couponList",dataType:"json",data:{businessCategory:"AUTO_INVEST_PLAN",payAmount:data.amount,businessId:data.autoinvestId},success:function(result){var coupon=result.data,selectDefault=coupon[0]&&coupon[0].couponId;ReactDOM.render(React.createElement(RCoupon,{selectOnChange:selectCallback.bind(this),selectDefault:selectDefault,queryCoupon:queryCoupon,coupon:coupon}),document.getElementById("coupon")),selectCallback(selectDefault,coupon)}}),$(".autoinvest-buy-form .agreement i").on("click",function(){var checkbox=$(this);checkbox.hasClass("icon-we-weigouxuanicon")?(checkbox.removeClass("icon-we-weigouxuanicon"),checkbox.addClass("icon-we-gouxuanicon"),$(".autoinvest-buy-form .agree-tip").remove()):(checkbox.addClass("icon-we-weigouxuanicon"),checkbox.removeClass("icon-we-gouxuanicon"))})},modifyTemplateStyle=function(id){var modal=null;modal=$(id?"#"+id+" .autoinvest-buy-form":".autoinvest-buy-main .autoinvest-buy-form");var topOffest=($(window).height()-modal.height())/2+$(window).scrollTop();topOffest=0>topOffest?0:topOffest,modal.css({top:topOffest})};return AutoinvestPayWindow}();module.exports=obj});
;/*!/client/widget/product/detail/status/status.js*/
define("autoinvest:widget/product/detail/status/status.js",function(require,exports,module){"use strict";var $=require("common:widget/lib/jquery/jquery"),formatSeconds=function(value,divid,sta){var theTime=parseInt(value,10),theTime1=0,theTime2=0,theTime3=0;theTime>60&&(theTime1=parseInt(theTime/60,10),theTime=parseInt(theTime%60,10),theTime1>60&&(theTime2=parseInt(theTime1/60,10),theTime1=parseInt(theTime1%60,10)),theTime2>24&&(theTime3=parseInt(theTime2/24,10),theTime2=parseInt(theTime2%24,10)));var result="";result=theTime3>0?""+parseInt(theTime3,10)+"天"+parseInt(theTime2,10)+"时":theTime2>0?""+parseInt(theTime2,10)+"时"+parseInt(theTime1,10)+"分":parseInt(theTime1,10)+"分"+parseInt(theTime,10)+"秒","#J_WAIT_BUTTON"==divid?(result="",result=theTime3>0?""+parseInt(theTime3,10)+"天"+parseInt(theTime2,10)+"时"+parseInt(theTime1,10)+"分":""+parseInt(theTime2,10)+"时"+parseInt(theTime1,10)+"分"+parseInt(theTime,10)+"秒",$(divid).css("letter-spacing","0"),"0"===sta&&(result=result),"3"===sta&&(result=result)):("0"===sta&&(result+="后预定"),"3"===sta&&(result+="开始加入")),$(divid).html(result)};module.exports={init:function(){this.timeRemaining("#J_WAIT_BUTTON")},inputFocus:function(){var input=$(".autoinvest-product .amount-ipt input");input.blur(function(){$("#autoinvest-product-input-tip").hide(),$(this).css({borderColor:"#ebebeb"})})},timeRemaining:function(id){if($(id).length<=0||"3"!==$(id).attr("data2")&&"0"!==$(id).attr("data2")||"-1"===$(id).attr("data1"))return!1;var totaltime=$(id).attr("data1"),timeid=setInterval(function(){totaltime-=1,formatSeconds(totaltime,id,$(id).attr("data2")),0>=totaltime&&(clearInterval(timeid),location.reload())},1e3)}}});
;/*!/client/widget/product/detail/tab/tab.js*/
define("autoinvest:widget/product/detail/tab/tab.js",function(require,exports,module){"use strict";var $=require("common:widget/lib/jquery/jquery"),React=require("common:node_modules/react/react"),ReactDOM=require("common:node_modules/react-dom/index"),BuyRecord=require("autoinvest:widget/product/detail/join-record/list/list");module.exports={init:function(data){this.selectTab(),this.renderBuyRecord(data)},selectTab:function(){var tab=$(".autoinvest-product .tab-bar > div"),content=$(".autoinvest-product .content > div");tab.on("click",function(){tab.removeClass("active"),content.removeClass("active");var currentTab=$(this),idx=currentTab.index();currentTab.addClass("active"),content.eq(idx).addClass("active")})},renderBuyRecord:function(list){ReactDOM.render(React.createElement(BuyRecord,{data:list}),document.getElementById("autoinvest-product-join-record"))}}});
;/*!/client/widget/user/detail/pay-popup/pay-popup.js*/
define("autoinvest:widget/user/detail/pay-popup/pay-popup.js",function(require,exports,module){var React=require("common:node_modules/react/react"),ReactDOM=require("common:node_modules/react-dom/index"),RCoupon=require("common:widget/react-ui/RCoupon/RCoupon"),$=require("common:widget/lib/jquery/jquery"),obj=function(){var AutoinvestPayWindow=function(){var options=arguments[0]||{};this.type=options.type,this.data=options.data,this.submit=options.submitCallback,this.cancel=options.cancelCallback,this.modal=createModal.call(this),initializeEvents.call(this)};AutoinvestPayWindow.prototype.show=function(){this.modal.style.display="block",modifyTemplateStyle()},AutoinvestPayWindow.prototype.hide=function(){this.modal.style.display="none",this.modal.parentNode.removeChild(this.modal),this.modal=null};var createModal=function(){var oDiv=document.createElement("div");oDiv.className="autoinvest-pay-main",oDiv.innerHTML=createTemplate(this.type,this.data);var root=document.getElementsByTagName("body")[0];return root.appendChild(oDiv),oDiv},createTemplate=function(type,data){var config=templateConfig(type),title=config.title||data.title,tpl=config.tpl(data),buttonGroup=footerButtonGroup(config.showCancelBtn,type,data);return'\n                <div class="autoinvest-shadow"></div>\n                <div class="autoinvest-pay-form">\n                    <div class="form-header">\n                        <span class="form-title">'+title+'</span>\n                        <span class="dialog-close-btn J-autoinvest-close">×</span>\n                    </div>\n                    <div class="form-content">\n                        '+tpl+'\n                    </div>\n                    <div class="form-footer">\n                        '+buttonGroup+"\n                    </div>\n                </div>\n            "},unpayContentTemplate=function(data){var nickname=data.nickname,allowDays=data.allowDays;return'<div class="popup-unpay-wrap">\n                    <div class="tip-icon icon-we-failed"></div>\n                    <div class="popup-unpay-text">\n                    尊敬的'+nickname+": 每月投资日前"+allowDays+"天才可支付\n                    </div>\n                </div>"},payCurrentPeriodTemplate=function(data){var id=data.id,amount=data.amount.toFixed(2);return'<div class="pay-form">\n                    <div class="period"><span class="l-title">支付期数</span> <span class="text-value">'+id+'</span></div>\n                    <div class="amount"><span class="l-title">月投资金额</span> <span class="text-value invest-money" data-invest-money="'+amount+'">'+amount+'元</span></div>\n                    <div class="coupon fn-clear" id="coupon"><span class="l-title">优惠券</span> <span class="text-value"></span></div>\n                    <div class="real-money"><span class="l-title">应付金额</span> <span class="text-value actual-price" data-actual-money="'+amount+'">'+amount+"元</span></div>\n                </div>"},addPayTemplate=function(data){return'<div class="pay-form">\n                    <div class="period"><span class="l-title">支付期数</span> <span class="text-value">'+data.id+'</span></div>\n                    <div class="pay-date"><span class="l-title">应付日期</span> <span class="text-value">'+data.payDate+'</span></div>\n                    <div class="delay"><span class="l-title">延期天数</span> <span class="text-value">'+data.dueDays+'</span></div>\n                    <div class="amount"><span class="l-title">月投资金额</span> <span class="text-value invest-money" data-invest-money="'+data.amount+'">'+data.amount+'元</span></div>\n                    <div class="coupon fn-clear" id="coupon"><span class="l-title">优惠券</span> <span class="text-value"></span></div>\n                    <div class="real-money"><span class="l-title">应付金额</span> <span class="text-value actual-price" data-actual-money="'+data.amount+'">'+data.amount+"元</span></div>\n                </div>"},modifyTagTemplate=function(data){var tags="";return data.forEach(function(item){tags+='<li class="tag" id="'+item.id+'">'+item.name+"</li>"}),tags+='<li class="tag">其它 <input class="ml10 ui-input fn-hide" type="text"></li>','<div class="tag-container"><ul class="fn-clear">'+tags+"</ul></div>"},normalTemplate=function(data){var tpl="";return data.success&&(tpl='<div class="normal-popup-tip-icon icon-we-success"></div>'),tpl+='<div class="normal-popup-text">尊敬的'+data.nickname+": "+data.text+"</div>",data.success&&(tpl+='<div class="normal-success"><p>邀请好友投资, 您与好友各得1%加息券,</p><p>多邀多得, 快快<a href="/pc/event/invitefriends/invitefriends">邀请壕友</a>。</p></div>'),tpl},footerButtonGroup=function(showCancelButton,type,data){var buttonGroup=showCancelButton?'<div class="cancel J-autoinvest-cancel">取消</div>':"";if(buttonGroup+='<div class="submit J-autoinvest-submit">确定</div>',"ADD_PAY"==type){var tip=data.totalDueDays<=data.maxDueDays?"小于等于"+data.maxDueDays+"天，退出时不扣延期费用":'退出时将扣除<a target="_blank" href="/pc/about/rrdHelp/topic/p/investment/fn/58734a531538f40e2773639a">延期费用</a>';buttonGroup+='<div class="add-tip">\n                                <div class="title">温馨提示</div>\n                                <div class="msg">您的累计的延期天数为'+data.totalDueDays+"天，"+tip+"，请下次注意哦~</div>\n                            </div>"}return buttonGroup},templateConfig=function(modalType){var tplMap={UNPAY:{tpl:unpayContentTemplate,title:"支付",showCancelBtn:!1},TAG:{tpl:modifyTagTemplate,title:"修改标签",showCancelBtn:!1,initEvent:modifyTagEvent},PAY:{tpl:payCurrentPeriodTemplate,title:"支付",showCancelBtn:!1,initEvent:getCouponEvent},ADD_PAY:{tpl:addPayTemplate,title:"补加入",showCancelBtn:!1,initEvent:getCouponEvent},NORMAL:{tpl:normalTemplate,showCancelBtn:!1}};return tplMap[modalType]},initializeEvents=function(){var _this=this,submitBtn=$(".J-autoinvest-submit"),closeBtn=[$(".J-autoinvest-cancel"),$(".J-autoinvest-close")];submitBtn.on("click",function(){if(-1!=_this.type.indexOf("PAY")){var payMoney=$(".autoinvest-pay-form .actual-price").data("actual-money");if(payMoney>_this.data.dueAccountMoney){var oParent=$(".autoinvest-pay-form .pay-form");if(!oParent.hasClass("disable-pay")){var tip=$("<span class=\"due-tip\">您的余额不足  　<a href='/pc/user/trade/recharge'>充值</a></span>");$(".autoinvest-pay-form .pay-form").append(tip),oParent.addClass("disable-pay")}return!1}}_this.submit&&_this.submit(_this.data),_this.hide()}),closeBtn.forEach(function(item){item.on("click",function(){_this.cancel&&_this.cancel(),_this.hide()})});var tplConf=templateConfig(_this.type);tplConf.initEvent&&tplConf.initEvent(_this.data)},getCouponEvent=function(data){function selectCallback(id,list){var investDom=$(".autoinvest-pay-form .invest-money"),investMoney=parseInt(investDom.data("invest-money")),priceDom=$(".autoinvest-pay-form .actual-price");id?list.forEach(function(item){if(id==item.couponId){var actualPrice=investMoney-item.couponValue;priceDom.html(actualPrice.toFixed(2)+"元"),priceDom.data("coupon-id",id),priceDom.data("actual-money",actualPrice),data.couponId=priceDom.data("coupon-id")}}):(priceDom.html(investMoney.toFixed(2)+"元"),priceDom.data("actual-money",investMoney),priceDom.removeData("coupon-id"),data.couponId=null)}var queryCoupon={businessCategory:"AUTO_INVEST_PLAN",payAmount:data.amount,bindScene:1};$.ajax({url:"/pc/transfer/detail/couponList",dataType:"json",data:{businessCategory:"AUTO_INVEST_PLAN",payAmount:data.amount,businessId:data.autoinvestId},success:function(result){var coupon=result.data,selectDefault=coupon[0]&&coupon[0].couponId;ReactDOM.render(React.createElement(RCoupon,{selectOnChange:selectCallback.bind(this),selectDefault:selectDefault,queryCoupon:queryCoupon,coupon:coupon}),document.getElementById("coupon")),selectCallback(selectDefault,coupon)}})},modifyTagEvent=function(){var tags=$(".tag-container li");tags.on("click",function(){tags.removeClass("active"),$(this).addClass("active")})},modifyTemplateStyle=function(){var modal=$(".autoinvest-pay-main .autoinvest-pay-form");modal.css({top:($(window).height()-modal.height())/2+$(window).scrollTop()})};return AutoinvestPayWindow}();module.exports=obj});
;/*!/client/widget/user/detail/record-list/list-main/list-main.js*/
define("autoinvest:widget/user/detail/record-list/list-main/list-main.js",function(require,exports,module){function _classCallCheck(instance,Constructor){if(!(instance instanceof Constructor))throw new TypeError("Cannot call a class as a function")}function _inherits(subClass,superClass){if("function"!=typeof superClass&&null!==superClass)throw new TypeError("Super expression must either be null or a function, not "+typeof superClass);subClass.prototype=Object.create(superClass&&superClass.prototype,{constructor:{value:subClass,enumerable:!1,writable:!0,configurable:!0}}),superClass&&(Object.setPrototypeOf?Object.setPrototypeOf(subClass,superClass):subClass.__proto__=superClass)}var React=require("common:node_modules/react/react"),InvestDetail=(require("common:node_modules/react-dom/index"),require("common:widget/p2p/autoinvest/invest-detail/invest-detail")),moment=require("common:node_modules/moment/moment"),numeral=require("common:node_modules/numeral/numeral"),$=require("common:widget/lib/jquery/jquery"),AutoInvestRecordListMain=function(_React$Component){function AutoInvestRecordListMain(props){_classCallCheck(this,AutoInvestRecordListMain),_React$Component.call(this,props),this.handleDetailClick=this.handleDetailClick.bind(this)}return _inherits(AutoInvestRecordListMain,_React$Component),AutoInvestRecordListMain.prototype.componentWillMount=function(){this.setState({toggle:!1,subPointId:$(".autoinvest-user .record-list-wrap").data("sub-point-id")})},AutoInvestRecordListMain.prototype.componentWillReceiveProps=function(){this.state.toggle===!0&&this.setState({toggle:!1})},AutoInvestRecordListMain.prototype.render=function(){var item=this.props.item,index=this.props.index,date=moment(item.lendTime).format("YYYY-MM-DD"),money=numeral(item.lendAmount).format("0.00"),badge=this.getBadge(item.displayLoanType);return item.status=this.loanStatus(item.status),item.hasContract=!0,("招标中"==item.status||"已满标"==item.status||"已流标"==item.status)&&(item.hasContract=!1),item.lendShare>0&&item.transferShare>0?(item.status="转让中",item.transferring=!0):0===item.lendShare&&(item.status="转让完成",item.transferring=!0),React.createElement("div",{className:"record-list-item-wrap"},React.createElement("div",{className:"fn-clear record-list-item"+(index%2==0?" odd":"")},React.createElement("div",{className:"id"},React.createElement("span",{className:"badge"},badge)," ",React.createElement("a",{href:"/loan/"+item.loanId,target:"_blank"},item.loanId)),React.createElement("div",{className:"money"},money,"元"),React.createElement("div",{className:"count"},item.lendShare),React.createElement("div",{className:"time"},date),React.createElement("div",{className:"status"},item.status," ",item.transferring?React.createElement("span",{className:"details-btn",onClick:this.handleDetailClick},React.createElement("a",{href:"javascript:;"},"明细")," ",React.createElement("i",{className:0==this.state.toggle?"icon-we-down":"icon-we-up"})):""," "),React.createElement("div",{className:"agreement"},item.hasContract?React.createElement("a",{href:"/account/borrowContract.action?loanId="+item.loanId,target:"_blank"},"合同"):"")),this.state.toggle?React.createElement(InvestDetail,{subPointId:this.state.subPointId,loanId:item.loanId}):"")},AutoInvestRecordListMain.prototype.getBadge=function(type){var typeMap={SDRZ:"实",XYRZ:"信",JGDB:"保",ZNLC:"智"};return typeMap[type]?typeMap[type]:""},AutoInvestRecordListMain.prototype.loanStatus=function(status){return"string"!=typeof status&&(status=parseInt(status,10)),0===status||"OPEN"==status?"招标中":1==status||"READY"==status?"已满标":2==status||"FAILED"==status?"已流标":3==status||"IN_PROGRESS"==status?"还款中":4==status||"OVER_DUE"==status?"逾期":5==status||"BAD_DEBT"==status?"坏账":6==status||"CLOSED"==status?"已还清":7==status||"FIRST_APPLY"==status?"申请中":8==status||"FIRST_READY"==status?"已满标":9==status||"PRE_SALES"==status?"预售中":11==status||"FANGBIAO_PROCESSING"==status?"放款中":12==status||"LIUBIAO_PROCESSING"==status?"流标中":""},AutoInvestRecordListMain.prototype.handleDetailClick=function(){this.setState({toggle:!this.state.toggle})},AutoInvestRecordListMain}(React.Component);module.exports=AutoInvestRecordListMain});
;/*!/client/widget/user/detail/record-list/list-wrap/list-wrap.js*/
define("autoinvest:widget/user/detail/record-list/list-wrap/list-wrap.js",function(require,exports,module){"use strict";var _extends=Object.assign||function(target){for(var i=1;i<arguments.length;i++){var source=arguments[i];for(var key in source)Object.prototype.hasOwnProperty.call(source,key)&&(target[key]=source[key])}return target},React=require("common:node_modules/react/react"),ReactDOM=require("common:node_modules/react-dom/index"),List=require("common:widget/react-ui/RList/List"),ListMain=require("autoinvest:widget/user/detail/record-list/list-main/list-main");module.exports={init:function(data){this.renderList(data,0,10,document.getElementById("recordMain"))},renderList:function(result,startNum,limit,dom){var params={subPointId:$(".autoinvest-user .record-list-wrap").data("sub-point-id")};ReactDOM.render(React.createElement(List,_extends({},result,{moudleServiceName:"autoinvest",url:"getAutoInvestRecordList",ajaxParams:params,isHeadNeed:"yes",isHeadNeedOrder:"no",createHeadDom:this.createHeadDom,createRowDom:this.createRowDom,startNum:startNum,limit:limit,offset:5})),dom)},createRowDom:function(item,index){return React.createElement(ListMain,{item:item,index:index})},createHeadDom:function(){return React.createElement("div",{className:"list-head fn-clear"},React.createElement("div",{className:"id"},"债权ID"),React.createElement("div",{className:"money"},"投资金额"),React.createElement("div",{className:"count"},"持有份数"),React.createElement("div",{className:"time"},"投资时间"),React.createElement("div",{className:"status"},"状态"))}}});