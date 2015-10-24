<?php
/**
* GoodRESTPostTypeController
* Class 
* Requires PHP 5.3.0 and above
*
* @version 0.1
* @package GoodRESTPostTypeController
* @link      http://gholme4.github.io/GoodREST/classes/GoodREST.html
* @copyright Copyright (c) 2015 George Holmes II
* @license   GPLv2 or later
*/
	
if ( ! class_exists( 'GoodRESTPostTypeController' ) ) :

class GoodRESTPostTypeController {

	/**
	* Post type slug
	* 
	* @var string $post_type
	*/
	protected $post_type;

	function __construct ($post_type) {
		$this->post_type = $post_type;
	}

	/**
	* Get single post
	* 
	* @param array $params
	*
	*/
	public function get($params) {
		$response = new stdClass();

		// Get post by ID
		$post = get_post($params['id']);
		
		// Check if post exists and if it is of the requested post type
		if (!$post || $post->post_type != $this->post_type)
		{
			$response->error = _("Post does not exist.");
		}
		else
		{
			$response->post = $post;
		}

		GoodREST::response(json_encode($response), 200);
	}

	/**
	* Create new post
	* 
	* @param array $params
	*
	*/
	public function post($params) {
		GoodREST::response("", 200);
	}

	/**
	* Update post
	* 
	* @param array $params
	*
	*/
	public function put($params) {
		// Check for constant and define it when calling this function, to prevent an infinite loop from the "save_post" hook
		if ( ! defined( 'GR_SAVE_POST_DATA' ) ) 
		{
        	
        	define( 'GR_SAVE_POST_DATA', TRUE );    
 			$response = new stdClass();

 			// Get post by ID
			$post = get_post($params['id']);

			// Check if post exists and if it is of the requested post type
			if (!$post || $post->post_type != $this->post_type)
			{
				$response->error = _("Post does not exist.");
			}
			else
			{
				$params['ID'] = $params['id'];
				unset($params["id"]);
				wp_update_post( $params );
				$response->post = $post;
			}

			GoodREST::response(json_encode($response), 200);
		}
	}

	/**
	* Delete post
	* 
	* @param array $params
	*
	*/
	public function delete($params) {
		// Check for constant and define it when calling this function, to prevent an infinite loop from the "save_post" hook
		if ( ! defined( 'GR_SAVE_POST_DATA' ) ) 
		{

			define( 'GR_SAVE_POST_DATA', TRUE );
			$response = new stdClass();
			
			// Get post by ID
			$post = get_post($params['id']);

			// Check if post exists and if it is of the requested post type
			if (!$post || $post->post_type != $this->post_type)
			{
				$response->error = _("Post does not exist.");
			}
			else
			{
				$response->post = wp_delete_post($params['id']);	
			}
				
			GoodREST::response(json_encode($response), 200);
		}
	}

	/**
	* Get posts
	* 
	* @param array $params
	*
	*/
	public function query($params) {
		GoodREST::response("", 200);
	}
	

}


endif;

?>