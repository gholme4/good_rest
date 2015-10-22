<?php

$post_types = get_post_types();

unset($post_types['attachment']);
unset($post_types['revision']);
unset($post_types['nav_menu_item']);

// Generate new API key
if(isset($_POST['good_rest_generate_api_key'])):

	ob_clean();
	echo uniqid();
	exit;

endif;

// Save settings
if(isset($_POST['save_good_rest_settings'])):

	update_option('good_rest_api_endpoint_prefix', sanitize_text_field($_POST['good_rest_api_endpoint_prefix']) );
	update_option('good_rest_api_key', sanitize_text_field($_POST['good_rest_api_key']) );
	$settings_updated = true;
	
	foreach($post_types as $type)
	{
		$option = "good_rest_" . $type . "_get_enabled";
		if ( isset($_POST[$option]) )
			update_option($option, true);
		else
			update_option($option, false);

		$option = "good_rest_" . $type . "_post_enabled";
		if ( isset($_POST[$option]) )
			update_option($option, true);
		else
			update_option($option, false);

		$option = "good_rest_" . $type . "_put_enabled";
		if ( isset($_POST[$option]) )
			update_option($option, true);
		else
			update_option($option, false);

		$option = "good_rest_" . $type . "_delete_enabled";
		if ( isset($_POST[$option]) )
			update_option($option, true);
		else
			update_option($option, false);

		$option = "good_rest_" . $type . "_query_enabled";
		if ( isset($_POST[$option]) )
			update_option($option, true);
		else
			update_option($option, false);
	}

endif;

?>

<?php
// Get values of form settings
$api_endpoint_prefix = get_option("good_rest_api_endpoint_prefix") ? get_option("good_rest_api_endpoint_prefix") : "api";
$good_rest_api_key = get_option("good_rest_api_key") ? get_option("good_rest_api_key"): uniqid();
?>
<div class="wrap">
	<h1><?php _e("Good REST Settings"); ?></h1>

	<?php if ($settings_updated == true): ?>
	<div id="message" class="updated notice notice-success is-dismissible below-h2">
		<p><?php _e("Settings updated."); ?></p>
		<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e("Dismiss this notice."); ?></span></button>
	</div>
	<?php endif; ?>

	<form method="post" action="" novalidate="novalidate" id="good-rest-settings-form">
		<input type="hidden" name="save_good_rest_settings" value="true">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="good_rest_api_endpoint_prefix"><? _e("API Endpoint Prefix"); ?></label></th>
					<td><?php echo get_site_url(); ?>/<input name="good_rest_api_endpoint_prefix" type="text" id="good_rest_api_endpoint_prefix" value="<?php _e($api_endpoint_prefix ); ?>" class="regular-text"></td>
				</tr>

				<tr>
					<th scope="row"><label for="good_rest_api_key"><?php _e("API Key"); ?></label></th>
					<td>
						<input name="good_rest_api_key" type="text" id="good_rest_api_key" value="<?php _e($good_rest_api_key ); ?>" class="regular-text">
						<button class="button" id="generate-api-key"><?php _e("Generate New API Key"); ?></button>
					</td>
				</tr>
			
			</tbody>
		</table>
		<h2><?php _e("Built In Routes"); ?></h2>

		<table class="form-table routes-table">
			<thead class="routes-table-header">
				<tr>
					<td><?php _e("Enabled"); ?></td>
					<td><?php _e("HTTP Method"); ?></td>
					<td><?php _e("Route"); ?></td>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($post_types as $type)
				{
				?>
				<tr>
					<?php $option = "good_rest_" . $type . "_get_enabled"; ?>
					<td><input type="checkbox" name="<?php echo $option; ?>" <?php if (get_option($option) == true) echo "checked"; ?> value="true"/></td>
					<td><?php _e("GET"); ?></td>
					<td><?php echo get_site_url() . '/' . $api_endpoint_prefix  . '/' . $type . "/:id"; ?></td>
				</tr>

				<tr>
					<?php $option = "good_rest_" . $type . "_post_enabled"; ?>
					<td><input type="checkbox" name="<?php echo $option; ?>" <?php if (get_option($option) == true) echo "checked"; ?> value="true"/></td>
					<td><?php _e("POST"); ?></td>
					<td><?php echo get_site_url() . '/' . $api_endpoint_prefix  . '/' . $type; ?></td>
				</tr>

				<tr>
					<?php $option = "good_rest_" . $type . "_put_enabled"; ?>
					<td><input type="checkbox" name="<?php echo $option; ?>" <?php if (get_option($option) == true) echo "checked"; ?> value="true"/></td>
					<td><?php _e("PUT"); ?></td>
					<td><?php echo get_site_url() . '/' . $api_endpoint_prefix  . '/' . $type . "/:id"; ?></td>
				</tr>

				<tr>

					<?php $option = "good_rest_" . $type . "_delete_enabled"; ?>
					<td><input type="checkbox" name="<?php echo $option; ?>" <?php if (get_option($option) == true) echo "checked"; ?> value="true"/></td>
					<td><?php _e("DELETE"); ?></td>
					<td><?php echo get_site_url() . '/' . $api_endpoint_prefix  . '/' . $type . "/:id"; ?></td>
				</tr>

				<tr>
					<?php $option = "good_rest_" . $type . "_query_enabled"; ?>
					<td><input type="checkbox" name="<?php echo $option; ?>" <?php if (get_option($option) == true) echo "checked"; ?> value="true"/></td>
					<td><?php _e("POST"); ?></td>
					<td><?php echo get_site_url() . '/' . $api_endpoint_prefix  . '/' . $type . "/q"; ?></td>
				</tr>

				<?php
				}
				?>
				
			</tbody>
		</table>
		<br><br>
		<h2><?php _e("Custom Routes"); ?></h2>

		<table class="form-table routes-table">
			<thead class="routes-table-header">
				<tr>
					<td><?php _e("HTTP Method"); ?></td>
					<td><?php _e("Route"); ?></td>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach(GoodREST::$routes as $route)
				{
				?>
				<tr>
					<td><?php echo $route->http_method[0]; ?></td>
					<td><?php echo get_site_url() . '/' . $api_endpoint_prefix  . '/' . $route->path; ?></td>
				</tr>
				<?php
				}
				?>
				
			</tbody>
		</table>

		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Settings"></p></form>
	</form>
	


</div>