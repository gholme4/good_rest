<?php
/**
 * Plugin Name: Good REST
 * Description: Developer plugin for creating RESTful routes. 
 * Version: 1.0
 * Plugin URI: https://github.com/gholme4/good_rest
 * Author: George Holmes II
 * Author URI: http://georgeholmesii.com
 */

//License: GPLv2 or later

//  Copyright 2015  George Holmes II  (email : george@georgeholmesii.com)

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


/* If PHP version if less than 5.3.0 abort */
if ( phpversion() < 5.3 ) {
	error_log("Good REST requires PHP 5.3.0 and above. Please upgrade PHP.", 0);
} 
else
{
	require_once 'lib/classes/GoodRESTPostTypeController.php';
	require_once 'lib/classes/GoodRESTCustomPostTypesRoutes.php';
	require_once 'lib/classes/GoodRESTUtil.php';
	require_once 'lib/classes/GoodRESTRouter.php';
	require_once 'lib/classes/GoodREST.php';

	GoodREST::init();

}
?>