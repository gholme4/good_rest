<?php
/**
* GoodRESTPostTypeController
*  
* Requires PHP 5.3.0 and above
*
* @version 0.1
* @package GoodREST
* @link      https://github.com/gholme4/good_rest/
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
			// Get other data associated with this post
			$post_meta = get_post_meta($params['id']);
			if (is_array($post_meta) && sizeof($post_meta)) {
				foreach($post_meta as $k => $v)
				{
					$post->$k = $v[0];
				}
			}
			
			// Set permalink
			$post->permalink = get_permalink( $post->ID );
			// Get post tags
			$post->tags = get_the_tags($post->ID);
			// Get post categories
			$post->categories = get_the_category( $post->ID );
			
			// Get thumbnails of each available size and add them to the post object
			$thumbnail_id = get_post_thumbnail_id( $post->ID);
			$images_sizes = get_intermediate_image_sizes();
			$post->thumbnail = array();
			foreach ($images_sizes as $size) {
				$image = NULL;
				$image = wp_get_attachment_image_src( $thumbnail_id, $size);
				$post->thumbnail[$size] = $image[0];
			}
			$full_image = wp_get_attachment_image_src( $thumbnail_id, "full");
			$post->thumbnail["full"] = $full_image[0];
			$post->timestamp = get_the_time('U', $id);
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
		if ( ! defined( 'GR_SAVE_POST_DATA' ) ) 
		{
        	
        	define( 'GR_SAVE_POST_DATA', TRUE ); 

 			$response = new stdClass();
			$params['post_type'] = $this->post_type;

			$result = wp_insert_post($params);

			if ($result)
			{
				$response->post = get_post($result);
			}
			else
			{
				$response->error = _("Post insert failed.");
			}

			GoodREST::response(json_encode($response), 200);
		}
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
		if ( ! defined( 'GR_SAVE_POST_DATA' ) ) 
		{

			define( 'GR_SAVE_POST_DATA', TRUE );
			
			$params['post_type'] = $this->post_type;
			$posts = get_posts($params);
			GoodREST::response(json_encode($posts), 200);
		}
	}
	

}


endif;

?>