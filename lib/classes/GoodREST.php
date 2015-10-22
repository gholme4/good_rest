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
	* @since GoodRESTRouter (0.1)
	* @var string $api_key
	*/	
	static public $api_key;

	/**
	* API endpoint path
	* 
	* @since GoodRESTRouter (0.1)
	* @var string $api_endpoint
	*/
	static public $api_endpoint;

	/**
	* Array of defined routes
	* 
	* @since GoodREST (0.1)
	* @var array $routes
	*/
	static public $routes = array();

	/**
	* Array of built in routes for registerd post types
	* 
	* @since GoodREST (0.1)
	* @var array $built_in_routes
	*/
	static public $built_in_routes = array();

	/**
	* GoodRESTRouter instance
	* 
	* @since GoodREST (0.1)
	* @access protected
	* @var GoodRESTRouter $router
	*/
	static protected $router;

	/**
	* GoodRESTUtil instance
	* 
	* @since GoodREST (0.1)
	* @access protected
	* @var GoodRESTUtil $router
	*/
	static protected $util;

	/**
	* Set up GoodREST
	* 
	* @since GoodREST (0.1)
	*/
	static public function init () {
		self::$api_endpoint = get_option("good_rest_api_endpoint_prefix") ? get_option("good_rest_api_endpoint_prefix") : "api";
		self::$api_key = get_option("good_rest_api_key");
		self::$router = new GoodRESTRouter();
		self::$util = new GoodRESTUtil();
	
	}

	/**
	* Add new GET route
	* 
	* @since GoodREST (0.1)
	* @var string $path
	* @var function $callback
	*/
	static public function get($path, $callback) {
		self::add_route($path, array("GET"), $callback);
	}

	/**
	* Add new POST route
	* 
	* @since GoodREST (0.1)
	* @var string $path
	* @var function $callback
	*/
	static public function post($path, $callback) {
		self::add_route($path, array("POST"), $callback);
	}

	/**
	* Add new PUT route
	* 
	* @since GoodREST (0.1)
	* @var string $path
	* @var function $callback
	*/
	static public function put($path, $callback) {
		self::add_route($path, array("PUT", "OPTIONS"), $callback);
	}

	/**
	* Add new DELETE route
	* 
	* @since GoodREST (0.1)
	* @var string $path
	* @var function $callback
	*/
	static public function delete($path, $callback) {
		self::add_route($path, array("DELETE", "OPTIONS"), $callback);
	}

	/**
	* Add route to list of routes
	* 
	* @since GoodREST (0.1)
	* @var string $path
	* @var array $http_method
	* @var function $callback
	*/
	public function add_route($path, $http_method, $callback) {
		$route = new stdClass();
		$route->path = $path;
		$route->http_method = $http_method;
		$route->callback = $callback;
		self::$routes[] = $route;
		
	}

	/**
	* Send response to client
	* 
	* @since GoodREST (0.1)
	* @var string $path
	* @var int $status
	* @var string $content_type
	*/
	static public function response($response, $status = 200, $content_type = "text/html") {
		 status_header( $status );
		 header("Content-type: " . $content_type);
		 echo $response;
		 exit;
	}

	/**
	* Get request parameter
	* 
	* @since GoodREST (0.1)
	* @var string $param
	*/
	static public function param($param) {
		
	}

}

endif;

?>