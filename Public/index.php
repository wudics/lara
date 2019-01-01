<?php

/**
* 网站入口
*
* PHP version 5.6
*/

/* 系统常量 */
define('DS', DIRECTORY_SEPARATOR);  // 系统分隔符，Linux为 / ，Windows为 \
define('ROOT', dirname(__DIR__) . DS);  // 物理系统文件根目录，如：C:\wwwroot\myweb\
define('WWWROOT', str_replace('\\', '', dirname(dirname($_SERVER['SCRIPT_NAME']))) . '/');  // 网站根目录，如 /

/* 配置时区 */
date_default_timezone_set('Asia/Shanghai');

/* 注册Autoloader类文件自动加载 */
spl_autoload_register(function($class) {
	$file = ROOT . str_replace('\\', DS, $class) . '.php';
	if (is_readable($file)) {
		require $file;
	}
});

/* composer组件自动加载 */
require_once ROOT . 'vendor' . DS . 'autoload.php';

/* 自定义Error和Exception处理程序 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/* 核心路由 */
$router = new Core\Router();

$router->add('', ['controller' => 'Client', 'action' => 'index']);
$router->add('{controller}', ['action' => 'index']);
$router->add('{controller}/{action}');
//$router->add('{controller}/{id:\d+}/{action}');
//$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$router->dispatch($_SERVER['QUERY_STRING']);  // run application
