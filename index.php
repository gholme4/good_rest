<?php
/**
 * Plugin Name: Good REST
 * Description: Developer plugin for creating RESTful routes. 
 * Version: 1.0
 * Plugin URI: https://github.com/gholme4/good_rest
 * Author: George Holmes II
 * Author URI: http://georgeholmesii.com
 */

//License: MIT
/*
Copyright (c) 2015  George Holmes II  (email : george@georgeholmesii.com)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
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