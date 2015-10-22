<?php
/**
* GoodRESTCustomPostTypesRoutes
* Class 
* Requires PHP 5.3.0 and above
*
* @version 0.1
* @package GoodRESTCustomPostTypesRoutes
* @link      http://gholme4.github.io/GoodREST/classes/GoodREST.html
* @copyright Copyright (c) 2015 George Holmes II
* @license   GPLv2 or later
*/
	
if ( ! class_exists( 'GoodRESTCustomPostTypesRoutes' ) ) :

class GoodRESTCustomPostTypesRoutes {

	/**
	* Array of post type slugs
	* 
	* @since GoodRESTCustomPostTypesRoutes (0.1)
	* @var array $post_types
	*/
	protected $post_types;

	function __construct() {
		add_action('init', array($this, "get_custom_post_types" ) );
		
	}

	/**
	* Get slugs of all registered post types
	* 
	* @since GoodRESTCustomPostTypesRoutes (0.1)
	* @return string
	*/

	public function get_custom_post_types () {
		// types will be a list of the post type names
	    $this->post_types = get_post_types();

	    unset($this->post_types['attachment']);
	    unset($this->post_types['revision']);
	    unset($this->post_types['nav_menu_item']);

	    $this->build_cpt_routes();

	}

	/**
	* Get slugs of all registered post types
	* 
	* @since GoodRESTCustomPostTypesRoutes (0.1)
	*/

	protected function build_cpt_routes () {
		
		foreach( $this->post_types  as $type )
	    {	
	    	if (get_option('good_rest_' . $type . '_get_enabled') == true )
	    	{
		    	GoodREST::get($type . "/:id", function ($params) {
					$controller = new GoodRESTPostTypeController($type);
					$controller->get($params);
				});
		    }

		    if (get_option('good_rest_' . $type . '_post_enabled') == true )
	    	{
				GoodREST::post($type, function ($params) {
					$controller = new GoodRESTPostTypeController($type);
					$controller->get($params);
				});
			}

			if (get_option('good_rest_' . $type . '_put_enabled') == true )
	    	{
				GoodREST::put($type . "/:id", function ($params) {
					$controller = new GoodRESTPostTypeController($type);
					$controller->put($params);
				});
			}

			if (get_option('good_rest_' . $type . '_delete_enabled') == true )
	    	{
				GoodREST::delete($type . "/:id", function ($params) {
					$controller = new GoodRESTPostTypeController($type);
					$controller->delete($params);
				});
			}

			if (get_option('good_rest_' . $type . '_query_enabled') == true )
	    	{
				GoodREST::post($type . "/q", function ($params) {
					$controller = new GoodRESTPostTypeController($type);
					$controller->query($params);
				});
			}
	    }

	}

}

endif;

?>