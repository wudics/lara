<?php

namespace Core;

/**
* Base controller
*
* PHP version 5.6
*/
abstract class Controller
{
	/**
	* Parameters from the matched route
	* @var array
	*/
	protected $route_params = [];

	/**
	* Class constructor
	*
	* @param array $route_params  Parameters from the route
	*
	* @return void
	*/
	public function __construct($route_params) {
		$this->route_params = $route_params;
	}
	
	/**
	* Handler the call by not callable method, like private method
	* and methodAction with the Action surfix. (It is a action filter.)
	*
	* @param string $name  Passed to the method
	*
	* @param array $args  Passed to the method
	*
	* @return void
	*/
	public function __call($name, $args)
	{
		$method = $name . 'Action';
		if (method_exists($this, $method)) {
			if ($this->before() !== false) {
				call_user_func_array([$this, $method], $args);
				$this->after();
			}
		} else {
			//echo "Method $method not found in controller " . get_class($this);
			throw new \Exception("Method $method not found in controller " . get_class($this));
		}
	}
	
	/**
	* Before filter - called before an action method. Override when necessary.
	*
	* @return void
	*/
	protected function before()
	{
	}
	
	/**
	* After filter - called after an action method. Override when necessary.
	*
	* @return void
	*/
	protected function after()
	{
	}
}
