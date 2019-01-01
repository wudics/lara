<?php

namespace Core;

/**
* Router
*
* PHP version 5.6
*/
class View
{
	public static $engine = null;

	/**
	* Get view engine
	*
	* @return object
	*/
	public static function getEngine()
	{
		if (self::$engine == null) {
			self::$engine = new \Smarty;
			self::$engine->setTemplateDir(ROOT . 'App' . DS . 'Views' . DS . 'Client' . DS);
			self::$engine->setCompileDir(ROOT . 'App' . DS . 'Views' . DS . 'Client' . DS . 'Compile' . DS);
			self::$engine->setConfigDir(ROOT . 'App' . DS . 'Views' . DS . 'Client' . DS . 'Config' . DS);
			self::$engine->setCacheDir(ROOT . 'App' . DS . 'Views' . DS . 'Client' . DS . 'Cache' . DS);
			// self::$engine->caching = true;
			// self::$engine->cache_lifetime = 120;
			self::$engine->caching = false;
			self::$engine->cache_lifetime = 0;
			self::$engine->left_delimiter = '{@';
			self::$engine->right_delimiter = '@}';
		}
		return self::$engine;
	}

	/**
	* Render a view file of php
	*
	* @param string $view  The view file
	*
	* @return void
	*/
	public static function render($view, $args = [])
	{
		// extract($args, EXTR_SKIP);
		
		// $file = ROOT . 'App' . DS . 'Views' . DS . $view;
		// if (is_readable($file)) {
		// 	require $file;
		// } else {
		// 	//echo "$file not found";
		// 	throw new \Exception("$file not found");
		// }
	}
	
	/**
	* Render a view template using Twig
	*
	* @param string $template  The template file
	* @param array $args  Assosiative array of data to display in the view (optional)
	*
	* @return void
	*/
	public static function renderTemplate($template, $args = [])
	{
		// static $twig = null;
		// if ($twig === null) {
		// 	$loader = new \Twig_Loader_Filesystem(ROOT . 'App' . DS . 'Views');
		// 	$twig = new \Twig_Environment($loader);
		// }
		
		// echo $twig->render($template, $args);
	}
	 
}
