<?php
/* Smarty version 3.1.33, created on 2018-12-13 13:08:01
  from 'E:\AppServ\www\lara\App\Views\Client\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5c11e931d22af1_52283456',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c6aa45d33df9a29ce9d5ca300ff13de2fedbe9f5' => 
    array (
      0 => 'E:\\AppServ\\www\\lara\\App\\Views\\Client\\index.html',
      1 => 1544677676,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5c11e931d22af1_52283456 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>二维码支付页面</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<?php echo '<script'; ?>
 src="<?php echo @constant('WWWROOT');?>
Public/js/jquery-3.3.1.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo @constant('WWWROOT');?>
Public/js/popper-1.11.0.min.js"><?php echo '</script'; ?>
>
    <!-- <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"><?php echo '</script'; ?>
> -->
	<?php echo '<script'; ?>
 src="<?php echo @constant('WWWROOT');?>
Public/js/bootstrap-4.1.1.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="<?php echo @constant('WWWROOT');?>
Public/js/qrcode.min.js"><?php echo '</script'; ?>
>
	<link rel="stylesheet" href="<?php echo @constant('WWWROOT');?>
Public/css/bootstrap-4.1.1.min.css">
	<link rel="stylesheet" href="<?php echo @constant('WWWROOT');?>
Public/css/lara.css">
</head>
<style type="text/css">
.margin-top { margin-top: 1em; }
.myContent { width: 90%; margin-left: 5%; }
.modal-dialog { margin: auto; }
.mylable { min-width: 118px; }
.input-group-text { border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: 0; }
.form-control { border-top-right-radius: .25rem; border-bottom-right-radius: .25rem; }
.myInput { vertical-align: middle; }
#qr img { max-width: 100%; display: inline-block!important; }
@media screen and ( min-width:560px ) {
    .pcInput{
        min-width: 200px;;
    }
}
</style>
<body>
	<div class="form text-center myContent">
		<br />
		<span id="welcome" class="label label-default">
			感谢使用Lara支付！
		</span>
        <div style="height:20px;">

        </div>
		<div align="center" id="qr" class="margin-top" style="display: none; text-align: center;">

		</div>
		<div class="input-group justify-content-md-center margin-top">
			<label class="form-control col-md-3" style="border-radius: 0.25rem">
				<input type="radio" name="channel" value="wechat" checked="checked" class="myInput">
				微信支付
			</label>
			<div class="col-md-1 " style="min-height: 8px">
			</div>
			<label class="form-control col-md-3" style="border-radius: 0.25rem">
				<input type="radio" name="channel" value="alipay" class="myInput">
				支付宝　
			</label>
		</div>
		<span class="label label-default">
			<p style="padding-top: 20px;">一个最简单的支付测试应用，充值【>=2元】云计算资料将发送到您的邮箱</p>
		</span>
		<div class="input-group justify-content-md-center margin-top text-center" align="center" style="line-height: 38px;">
			<label class="input-group-text">
				支付金额(元):
			</label>
			<input type="number" class="form-control col-md-1 pcInput" id="money" value="2" min="1" max="3000000" style="border-top-right-radius: 0.25rem;border-bottom-right-radius: 0.25rem">
			
		</div>
		<div class="input-group justify-content-md-center margin-top text-center" align="center" style="display:none;">
			<label class=" input-group-text  mylable">
				充值用户： 
			</label>
			<input type="text" class="form-control col-md-1 pcInput" id="user_name" value="lara">
		</div>
		<div class="input-group justify-content-md-center margin-top text-center" align="center">
			<label class=" input-group-text  mylable">
				您的邮箱： 
			</label>
			<input type="text" class="form-control col-md-1 pcInput" id="yourmail" value="@qq.com">
		</div>
		<br>
		<div class="form-group margin-top">
			<button type="button" class="btn btn-primary" id="btn_submit" onClick="getQr();">
				- 我要资料 -
			</button>
		</div>
		<span style="color:#F30;font-weight:bold;display:none" id="pay_status">支付结果查询中...</span>
	</div>
	
	<!-- 下面是loading的模态框 -->
	<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop='static' data-keyboard='false'>
		<div class="modal-dialog" style="width:200px">
			<div class="modal-content">
				<div class="modal-body spinner center text-center">
				  <div class="bounce1"></div>
				  <div class="bounce2"></div>
				  <div class="bounce3"></div>
				</div>
			</div>
		</div>
	</div>

</body>

<?php echo '<script'; ?>
>

    var qr_thread = 0;
    var check_thread = 0;
	var yourmail = "513034966@qq.com";

	$('#loading').on('show.bs.modal', function (e) {
            $(this).css('display', 'block');
            var modalHeight = $(window).height() / 2 - $('#loading .modal-dialog').height() / 2;
            $(this).find('.modal-dialog').css({
                'margin-top': modalHeight
            });
    });
	var qrcode = new QRCode(document.getElementById("qr"), {
		width : 150,
		height : 150
	});


	function getQr() {

		if (!isEmail($("#yourmail").val())) {
			alert("请输入您的邮箱！");
			return;
		}

		yourmail = $("#yourmail").val();
		alert(yourmail);
		return;

		if(check_thread > 0) {
			$("#pay_status").text("支付结果查询中...");
			clearTimeout(check_thread);
			check_thread = 0;
        }
        
        if(qr_thread > 0) {
			$("#pay_status").text("等待创建二维码...");
			clearTimeout(qr_thread);
			qr_thread = 0;
		}
		
		var money = $("#money").val() * 100;
		var extra = $("#user_name").val();
        var channel = $("input[name='channel']:checked").val();
        
        // if (channel == "alipay") {
        //     alert("支付宝聚到暂未开通！");
        //     return;
        // }
		
		if (money < 1){
			alert("Hello, Lara!");
			return;
		}
		
		$('#loading').modal('show');
		$("#qr").css("display", "none");
        
        // 创建订单
		var url = "<?php echo @constant('WWWROOT');?>
order/create";
        var params = {money: money, extra: extra, channel: channel};
		$.post(url, params, function(data) {
			if (data.status != 1) {
				alert(data.message);
			} else {
                $("#pay_status").css("display", "inline");
				qr_thread = setTimeout("hasUrl('" + data.data.mark_sell + "', 1)", 2000);
			}
			setTimeout("$('#loading').modal('hide')", 800);
		}, "json");
	}
    
    function hasUrl(mark_sell, countdown) {

        if (countdown > 120) {
            $("#pay_status").text("在120秒内未创建二维码，请重新尝试！");
			return;
        }

        var url_get = "<?php echo @constant('WWWROOT');?>
order/geturl";
        var params_get = {mark_sell: mark_sell};
        $.post(url_get, params_get, function(data) {

            if (data.status != 1) {
                countdown = countdown + 2;
                qr_thread = setTimeout("hasUrl('" + mark_sell + "', " + countdown + ")", 2000);
				$("#pay_status").text("等待创建二维码...->" + countdown + "秒");
                return;
            }

            $("#welcome").text("二维码创建完成，请扫码支付（电脑），或长按二维码识别支付（微信）！");

            if (data.data.channel == "alipay") {
                if(navigator.userAgent.indexOf('Android') > -1) {
                    if(confirm("需要直接启动支付宝支付吗？")) {
                        window.open(data.data.url);
                    }
                }
            }

            qrcode.makeCode(data.data.url);
            $("#qr").css("display", "inline");
            check_thread = setTimeout("isPayed('" + data.data.mark_sell + "', 1)", 6000);
        }, "json");
    }

	function isPayed(var_mark_sell, count) {
		if(count > 600) {
			$("#pay_status").text("在600秒内未支付，请后续支付在个人页面查看！");
			return;
		}
		var url = "<?php echo @constant('WWWROOT');?>
order/check";
		var params = {mark_sell: var_mark_sell};
		$.post(url, params, function(data) {
			if(data.status != 1) {
				count = count + 2;
				check_thread = setTimeout("isPayed('" + var_mark_sell + "', " + count + ")", 2000);
				$("#pay_status").text("支付结果查询中...->" + count + "秒");
				return;
			}
			$("#pay_status").text("支付已经成功！支付返回结果：" + data.data);
			// alert("支付返回结果：" + data.data);
			sendMail(var_mark_sell, yourmail);
		}, "json");
	}

	function sendMail(mark_sell, email) {
		var url = "<?php echo @constant('WWWROOT');?>
order/sendmail";
		var params = {mark_sell: mark_sell, email: email};
		$.post(url, params, function(data) {
			if(data.status != 1) {
				alert(data.message + " " + data.data);
			} else {
				alert(data.data);
			}
		}, "json");
	}

	function isEmail(str){
		var re=/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
		if (re.test(str) != true) {
			return false;
		}else{
			return true;
		}
	}

	// if (isEmail("513034966@qq.com")) {
	// 	alert("is a email address");
	// } else {
	// 	alert("is not a email address");
	// }

	// sendMail("1544639277403", "513034966@qq.com");
	
<?php echo '</script'; ?>
>

</html>










<?php }
}
