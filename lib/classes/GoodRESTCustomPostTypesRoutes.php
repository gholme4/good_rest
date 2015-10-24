<?php
/**
* GoodRESTCustomPostTypesRoutes
*  
* Requires PHP 5.3.0 and above
*
* @version 0.1
* @package GoodREST
* @link      https://github.com/gholme4/good_rest/
* @copyright Copyright (c) 2015 George Holmes II
* @license   GPLv2 or later
*/
	
if ( ! class_exists( 'GoodRESTCustomPostTypesRoutes' ) ) :

class GoodRESTCustomPostTypesRoutes {

	/**
	* Array of post type slugs
	* 
	* @var array $post_types
	*/
	protected $post_types;

	function __construct() {
		add_action('init', array($this, "get_custom_post_types" ) );
		
	}

	/**
	* Get slugs of (almost) all registered post types
	* 
	* @return string
	*/

	public function get_custom_post_types () {
		// types will be a list of the post type names
	    $this->post_types = get_post_types();
	   
	    unset($this->post_types['revision']);
	    unset($this->post_types['nav_menu_item']);

	    $this->build_cpt_routes();

	}

	/**
	* Register routes for (almost) all registered post types
	* 
	*/

	protected function build_cpt_routes () {

		foreach( $this->post_types  as $key=>$type )
	    {	
	    	
	    	if (get_option('good_rest_' . $type . '_get_enabled') == true )
	    	{
		    	GoodREST::get($type . "/:id", function ($params, $args) {
		    		$controller = new GoodRESTPostTypeController($args['post_type']);
					$controller->get($params);
				}, array("post_type" => $type, "built_in" => true) );
		    }

		    if (get_option('good_rest_' . $type . '_post_enabled') == true )
	    	{
				GoodREST::post($type, function ($params, $args) {
					$controller = new GoodRESTPostTypeController($args['post_type']);
					$controller->post($params);
				}, array("post_type" => $type, "built_in" => true) );
			}

			if (get_option('good_rest_' . $type . '_put_enabled') == true )
	    	{
				GoodREST::put($type . "/:id", function ($params, $args) {

					$controller = new GoodRESTPostTypeController($args['post_type']);
					$controller->put($params);
				}, array("post_type" => $type, "built_in" => true) );
			}

			if (get_option('good_rest_' . $type . '_delete_enabled') == true )
	    	{
				GoodREST::delete($type . "/:id", function ($params, $args) {
					$controller = new GoodRESTPostTypeController($args['post_type']);
					$controller->delete($params);
				}, array("post_type" => $type, "built_in" => true) );
			}

			if (get_option('good_rest_' . $type . '_query_enabled') == true )
	    	{
				GoodREST::get("q/" . $type, function ($params, $args) {
					$controller = new GoodRESTPostTypeController($args['post_type']);
					$controller->query($params);
				}, array("post_type" => $type, "built_in" => true) );
			}
	    }

	}

}

endif;

?>