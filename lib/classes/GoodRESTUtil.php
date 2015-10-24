<?php
/**
* GoodRESTUtil
* Requires PHP 5.3.0 and above
*
* @version 0.1
* @package GoodREST
* @link      https://github.com/gholme4/good_rest/
* @copyright Copyright (c) 2015 George Holmes II
* @license   GPLv2 or later
*/
	
if ( ! class_exists( 'GoodRESTUtil' ) ) :

class GoodRESTUtil {

	function __construct() {
		
		add_action('admin_enqueue_scripts',  array( $this, 'admin_scripts' ), 10);
		add_action( 'admin_menu', array($this, 'admin_pages') );
		add_action( 'init', array($this, 'wp_init') );
	}

	/**
	* Enqueue admin scripts
	* 
	*/
	public function admin_scripts() {
		wp_enqueue_script( 'good_rest_admin_script', plugin_dir_url( __FILE__ ) . '/../../assets/js/script.js', array("jquery"), '1.0');
		wp_enqueue_style( 'good_rest_admin_style', plugin_dir_url( __FILE__ ) . '/../../assets/css/style.css', false, "1.0", "screen");
		
	}

	/**
	* WordPress init hook functions
	* 
	*/
	public function wp_init() {
			
		ob_start();
		
	}

	/**
	* Enqueue admin scripts
	* 
	*/
	public function admin_pages() {
		add_menu_page(
			'Good REST Settings',
			'Good REST Settings', 
			'manage_options',
			'good_rest_settings',
			function () {
				include dirname(__FILE__) . '/../admin-views/options.php';
			}
			, 
			false, 
			82 
		);
	}

}

endif;

?>