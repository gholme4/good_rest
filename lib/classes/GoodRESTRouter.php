<?php
/**
* GoodRESTRouter
*  
* Requires PHP 5.3.0 and above
*
* @version 0.1
* @package GoodREST
* @link      https://github.com/gholme4/good_rest/
* @copyright Copyright (c) 2015 George Holmes II
* @license   GPLv2 or later
*/
	
if ( ! class_exists( 'GoodRESTRouter' ) ) :

class GoodRESTRouter {

	function __construct() {
		new GoodRESTCustomPostTypesRoutes();
		add_action( 'pre_get_posts', array( $this, 'match_routes' ), 10);
		
	}

	/**
	* Get header value
	* 
	* @param string $header
	*
	* @return string
	*/
	protected function get_header($header) {
		$all_headers = getallheaders();
		foreach($all_headers as $key=>$value)
		{
			if ($header == $key)
				return $value;
		}

		return NULL;
	}

	/**
	* Check URL against defined routes
	* 
	*/
	public function match_routes() {
		// Combine built in routes and user defined routes
		GoodREST::$routes = array_merge(GoodREST::$built_in_routes, GoodREST::$custom_routes);

		error_log(json_encode(GoodREST::$routes));
		//  Loop through all defined routes
		foreach (GoodREST::$routes as $route) {

			// Collect all params in route path in $matches
			$pattern = '/\/:[A-Za-z0-9_]+/';
			$subject = $route->path;
			preg_match_all($pattern, $subject, $matches);

			// Build route match URI and escape slashes
			$route_match = get_site_url() . '/' . GoodREST::$api_endpoint . '/' . $route->path;
			
			$route_match = str_replace("/" , '\/', $route_match);

			// Replace params in route match with regex pattern for checking against this route
			foreach($matches[0] as $match) {
				$route_match = str_replace(rtrim($match, "/") , '/([A-Za-z0-9_]+)', $route_match);
			}

			// Add delimiters to route match pattern
			$route_match = "/" . $route_match . "$/";
			
			// If route path pattern matches URI and request has valid HTTP method...
			if ( preg_match( $route_match, $this->uri(), $param_matches) && in_array($_SERVER['REQUEST_METHOD'], $route->http_method) )
			{
				// Enable CORS, etc.
				header("Access-Control-Allow-Origin: *");
				header("Access-Control-Allow-Headers: x-wp-api-key");
				header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

				$params = array();

				// Add all $_REQUEST parameters to $params array
				foreach($_REQUEST as $key=>$val) 
				{
					$params[$key] = $val;
				}

				// Remove first element of new matches and build $params array
				array_shift($param_matches);
				for($i = 0; $i < count($matches[0]); $i++)
				{
					$params[ltrim($matches[0][$i], "/:")] = $param_matches[$i];
				}

				if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
				{
					// For clients (browsers) that send OPTIONS request before DELETE and PUT
					GoodREST::response("");
				}
				
				if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'DELETE')
				{
					// Add all parameters to from $_PUT request to $params array
					parse_str(file_get_contents("php://input"),$post_vars);
					foreach($post_vars as $key=>$val) 
					{
						$params[$key] = $val;
					}
				}

				if ($this->get_header("x-wp-api-key") != GoodREST::$api_key)
				{
					GoodREST::response("Invalid API key", 403);
				}

				// Run callback and pass parameters from $_REQUEST and URI
				call_user_func_array($route->callback, array($params, $route->args));
				
			}
			else
			{
				// skip to next iteration if route doesn't match
				continue;
			}

		}
	}

	/**
	* get current URI
	* 
	* @return string
	*/

	protected function uri () {
		$uri = 'http';
		if ($_SERVER["HTTPS"] == "on") {$uri .= "s";}
			$uri .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$uri .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$uri .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}

		$uri_array = explode("?", $uri);
		return $uri_array[0];

	}

}

endif;

?>