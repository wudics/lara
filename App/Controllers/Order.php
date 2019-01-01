<?php

namespace App\Controllers;

use \Core\View;
use \App\Common as Common;
use \App\Config as Config;
use \App\Models\Task;

/**
* Order controller
*
* PHP version 5.6
*/
class Order extends \Core\Controller
{
    /**
    * Create payment (order and task)
    *
    * @return void
	*/
	public function createAction()
	{
		if (empty($_POST['money'])) {
			echo Common::packData("error", "1", 0);
			return;
		}

		if (empty($_POST['extra'])) {
			echo Common::packData("error", "2", 0);
			return;
		}

		if (empty($_POST['channel'])) {
			echo Common::packData("error", "3", 0);
			return;
		}

		$money = $_POST['money'];
		$extra = $_POST['extra'];
		$channel = $_POST['channel'];

		if ($money < 1 || $money > 3000000) {
			echo Common::packData("error", "4", 0);
			return;
		}

		if ($channel != 'wechat' && $channel != 'alipay') {
			echo Common::packData("error", "5", 0);
			return;
		}

		$order = Task::newPayment($money, $extra, $channel);
		if (empty($order)) {
			echo Common::packData("error", "6", 0);
		} else {
			echo Common::packData("success", $order, 1);
		}
    }
    
    /**
    * Create task
    *
    * @return void
	*/
	public function createTaskAction()
	{
        if (empty($_POST['money'])) {
			echo Common::packData("error", "", 0);
			return;
		}

		if (empty($_POST['mark_sell'])) {
			echo Common::packData("error", "", 0);
			return;
		}

		if (empty($_POST['channel'])) {
			echo Common::packData("error", "", 0);
			return;
		}

		$money = $_POST['money'];
		$mark_sell = $_POST['mark_sell'];
		$channel = $_POST['channel'];

		if ($money < 1 || $money > 3000000) {
			echo Common::packData("error", "", 0);
			return;
		}

		if ($channel != 'wechat' || $channel != 'alipay') {
			echo Common::packData("error", "", 0);
			return;
		}

		$task = Task::newTask($money, $mark_sell, $channel);
		if (empty($task)) {
			echo Common::packData("error", "", 0);
		} else {
			echo Common::packData("success", $task, 1);
		}
	}

	/**
    * Check payment
    *
    * @return void
	*/
	public function checkAction()
	{
		if (empty($_POST['mark_sell'])) {
			echo Common::packData("error", "", 0);
			return;
		}

		$mark_sell = $_POST['mark_sell'];

		$payment = Task::getPaymentByMarkSell($mark_sell);
		if (empty($payment)) {
			echo Common::packData("error", "", 0);
			return;
		}

		if ($payment["haspay"] && $payment["money"] <= $payment["paymoney"]) {
			echo Common::packData("success", "success", 1);
			return;
		}

		echo Common::packData("error", "", 0);
	}

	public function getUrlAction()
	{
		if (empty($_POST['mark_sell'])) {
			echo Common::packData("error", "", 0);
			return;
		}

		$mark_sell = $_POST['mark_sell'];

		$payment = Task::getPaymentByMarkSell($mark_sell);

		if (empty($payment)) {
			echo Common::packData("error", "", 0);
			return;
		}

		if (!$payment["hasurl"] || empty($payment["url"])) {
			echo Common::packData("error", "", 0);
			return;
		}

		$data = [
			"mark_sell" => $payment["mark_sell"],
			"url" => $payment["url"]
		];

		echo Common::packData("success", $data, 1);
	}

	public function sendMailAction()
	{
		if (empty($_POST['mark_sell'])) {
			echo Common::packData("error", "1", 0);
			return;
		}

		$mark_sell = $_POST['mark_sell'];

		if (empty($_POST['email'])) {
			echo Common::packData("error", "2", 0);
			return;
		}

		$email = $_POST['email'];

		$payment = Task::getPaymentByMarkSell($mark_sell);
		if (empty($payment)) {
			echo Common::packData("error", "3", 0);
			return;
		}

		if ($payment["haspay"] && $payment["paymoney"] >= 200) {
			$mail = new \PHPMailer\PHPMailer\PHPMailer();
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = 'smtp.qq.com';
			$mail->SMTPSecure = 'ssl';
			$mail->Port = 465;
			$mail->CharSet = 'UTF-8';
			$mail->FromName = '猛男村村长';
			$mail->Username = '176367820@qq.com';
			$mail->Password = 'ppizplybukvvbgjc';
			$mail->From = '176367820@qq.com';
			$mail->isHTML(true);
			$mail->addAddress($email);
			$mail->Subject = '来自猛男村村长的邮件';
			$mail->Body = '<h1>感谢购买</h1><p>请复制链接在浏览器中打开，输入提取码后下载云计算资料</p><p>链接：https://pan.baidu.com/s/1ZI96TBzFpYTbjNcjON8MmA</p><p>提取码：83th</p>';
			$mail->send();
			echo Common::packData("success", "您将收到一份来自猛男村村长的邮件，请注意查收！", 1);
			return;
		}

		echo Common::packData("error", "4", 0);
		return;
	}
}
