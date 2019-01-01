<?php

namespace App\Controllers;

use \Core\View;
use \App\Common as Common;
use \App\Config as Config;
use \App\Models\Task;

/**
* Home controller
*
* PHP version 5.6
*/
class Home extends \Core\Controller
{
	/**
	* Before filter
	*
	* @return void
	*/
	protected function before()
	{
		//echo "(before)";
		//return true;  // false to abort.

		if (empty($_SERVER['HTTP_TOKEN'])) {
			return false;
		}

		// Task::log($_SERVER['HTTP_TOKEN']);

		$currentUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$decrypt = Common::decrypt($_SERVER['HTTP_TOKEN'], Config::LARA_PAY_TOKEN);
		$explode = explode("|", $decrypt);

		// Task::log($explode[1]);

		// if (count($explode) < 3 || $explode[1] != $currentUrl || $explode[2] != Config::LARA_PAY_TOKEN) {
		// 	return false;
		// }

		if (count($explode) < 2 || $explode[1] != $currentUrl) {
			return false;
		}

		$timestampStr = $explode[0];
		$dateStr = date('Y-m-d H:i:s', $timestampStr);
		$timestamp = strtotime($dateStr);

		$url = $explode[1];

		if (time() - $timestamp > 60 * 2) {
			return false;
		}

		return true;
	}
	
	/**
	* After filter
	*
	* @return void
	*/
	protected function after()
	{
		//echo "(after)";
	}
	
	/**
	* Show the index page
	*
	* @return void
	*/
	public function indexAction()
	{
		//echo 'Hello from the index action in the Home controller!';
		
		/*View::render('Home' . DS . 'index.php', [
			"name" => "Laura",
			"colours" => ["red", "green", "blue"]
		]);*/
		
		// View::renderTemplate('Home' . DS . 'index.html', [
		// 	"name" => "Laura",
		// 	"colours" => ["red", "green", "blue"]
        // ]);
        
		$this->showRouteParams();
		// echo "Hello, World!";
    }
    
    /**
    * Show route parameters
    *
    * @return void
    */
    public function showRouteParams()
    {
		echo "<pre>";
		print_r($_SERVER);
		echo "</pre>";
		echo '<p>Route parameters: <pre>' . htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
		
		// echo '<p>age: ' . $_GET['age'] . '</p>';
		// echo '<p>female: ' . $_GET['female'] . '</p>';

		echo "<pre>";
		print_r($_GET);
		echo "</pre>";

		echo "<p>DS: " . DS . "<p/>";
		echo "<p>ROOT: " . ROOT . "<p/>";
		echo "<p>WWWROOT: " . WWWROOT . "<p/>";
	}
	
	/**
	* Deal with pay action
	*
	* @return void
	*/
	public function payAction()
	{
		if (empty($_GET["command"])) {
			echo Common::packData("unknown error", "", 0);
			return;
		}
		$cmd = $_GET["command"];
		switch($cmd) {
			case "ask":
				$this->commandAsk();
				break;
			case "addqr":
				$this->commandAddqr();
				break;
			case "do":
				$this->commandDo();
				break;
			default:
				echo Common::packData("unknown error", "", 0);
		}
	}

	private function commandAsk()
	{
		$data = Task::getFresh();
		echo Common::packData("success", $data, 1);
	}

	private function commandAddqr()
	{
		$device = $_GET["dev"];
		$url = $_GET["url"];
		$mark_sell = $_GET["mark_sell"];

		$rnt = Task::applyPayment($mark_sell, $device, $url);
		echo Common::packData("success", "", 1);
	}

	private function commandDo()
	{
		$mark_sell = $_GET["mark_sell"];
		$mark_buy = $_GET["mark_buy"];
		$money = $_GET["money"];
		$device = $_GET["dev"];
		$channel_id = $_GET["order_id"];
		$rnt = Task::doPayment($mark_sell, $mark_buy, $money, $device, $channel_id);
		echo Common::packData("success", "", 1);
	}
}
