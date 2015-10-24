<?php
/**
* GoodREST
* Requests need to be of type application/x-www-form-urlencoded 
* Requires PHP 5.3.0 and above
*
* @version 0.1
* @package GoodREST
* @link      http://gholme4.github.io/GoodREST/classes/GoodREST.html
* @copyright Copyright (c) 2015 George Holmes II
* @license   GPLv2 or later
*/
	
if ( ! class_exists( 'GoodREST' ) ) :

class GoodREST {

	/**
	* API key to authorize requests
	* 
	* @var string $api_key
	*/	
	static public $api_key;

	/**
	* API endpoint path
	* 
	* @var string $api_endpoint
	*/
	static public $api_endpoint;

	/**
	* Array of defined routes
	* 
	* @var array $routes
	*/
	static public $routes = array();

	/**
	* Array of built in routes for registerd post types
	* 
	* @var array $built_in_routes
	*/
	static public $built_in_routes = array();

	/**
	* GoodRESTRouter instance
	* 
	* @access protected
	* @var GoodRESTRouter $router
	*/
	static protected $router;

	/**
	* GoodRESTUtil instance
	* 
	* @access protected
	* @var GoodRESTUtil $router
	*/
	static protected $util;

	/**
	* Set up GoodREST
	* 
	*/
	static public function init () {
		self::$api_endpoint = get_option("good_rest_api_endpoint_prefix") ? get_option("good_rest_api_endpoint_prefix") : "api";
		self::$api_key = get_option("good_rest_api_key") ? get_option("good_rest_api_key") : uniqid();
		self::$router = new GoodRESTRouter();
		self::$util = new GoodRESTUtil();
	
	}

	/**
	* Add new GET route
	* 
	* @since GoodREST (0.1)
	* @param string $path
	* @param function $callback
	* @param array $args
	*/
	static public function get($path, $callback, $args = null) {
		self::add_route($path, array("GET"), $callback, $args);
	}

	/**
	* Add new POST route
	* 
	* @since GoodREST (0.1)
	* @param string $path
	* @param function $callback
	* @param array $args
	*/
	static public function post($path, $callback, $args = null) {
		self::add_route($path, array("POST"), $callback, $args);
	}

	/**
	* Add new PUT route
	* 
	* @since GoodREST (0.1)
	* @param string $path
	* @param function $callback
	* @param array $args
	*/
	static public function put($path, $callback, $args = null) {
		self::add_route($path, array("PUT", "OPTIONS"), $callback, $args);
	}

	/**
	* Add new DELETE route
	* 
	* @param string $path
	* @param function $callback
	* @param array $args
	*/
	static public function delete($path, $callback, $args = null) {
		self::add_route($path, array("DELETE", "OPTIONS"), $callback, $args);
	}

	/**
	* Add route to list of routes
	* 
	* @param string $path
	* @param array $http_method
	* @param function $callback
	* @param array $args
	*/
	public function add_route($path, $http_method, $callback, $args = null) {
		$route = new stdClass();
		$route->path = $path;
		$route->http_method = $http_method;
		$route->callback = $callback;
		$route->args = $args;
		self::$routes[] = $route;
		
	}

	/**
	* Send response to client
	* 
	* @param string $path
	* @param int $status
	* @param string $content_type
	*/
	static public function response($response, $status = 200, $content_type = "text/html") {
		 status_header( $status );
		 header("Content-type: " . $content_type);
		 echo $response;
		 exit;
	}

}

endif;

?>