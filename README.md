# Good REST

Good REST is a WordPress plugin designed to open add REST API functionality to WordPress installations. This plugin is only intended to allow remote requests and not local routing. Features include:

  - Developer defined routes similar to Slim framework format
  - User enabled built-in routes from registerd post types
  - API key authentication
  - Dashboard page for managing plugin settings

### Installation
Download the zip of this repo and paste its contents in your site's plugins folder.

### Dashboard settings page
In the WordPress admin click the Good REST settings menu item to get to the settings page. There you have options to change the API endpoint prefix and generate a new API key. There is also a list of routes displayed. 

There are built in routes generated from registered post types. Each can be disabled by unchecking the box next it.

### Developer Instructions
To create routes, define them in the theme's functions file. It's possible to define dynamic routes for GET, POST, DELETE, and PUT requests and send parameters with each.
#### Code examples

##### GET request
#
```php
GoodREST::get("get_page/:id", function ($params) {
    // Logic here...
	GoodREST::response(json_encode($data));
});
```
> In the above example, $params will be an associative array containing "id" and query string parameters

##### POST request
#
```php
GoodREST::post("create_page", function ($params) {
    // Logic here...
	GoodREST::response("Page created.");
});
```

##### PUT request
#
```php
GoodREST::pust("update_page/:page_id", function ($params) {
    // Logic here...
	GoodREST::response("Page updated.");
});
```

##### DELETE request
#
```php
GoodREST::delete("delete_page/:page_id", function ($params) {
    // Logic here...
	GoodREST::response("Page deleted.");
});
```
This text you see here is *actually* written in Markdown! To get a feel for Markdown's syntax, type some text into the left window and watch the results in the right.

#### Responses
Always be sure to output a response in callbacks. GoodREST::response() can be used to send responses back to the client. Response content, status code, and content type can be passed as parameters.
```php
GoodREST::get("some_route", function ($params) {
	GoodREST::response("Response content", 200, "text/html");
});
```
#### Notes
When defining routes they will be prepended with your site URL and an api endpoint prefix which can be defined in the Good REST settings page. If the name of your is site "http://website.com" and your api endpoint prefix is "api", the code
```php
GoodREST::get("some_route", function ($params) {
	GoodREST::response("Response content");
});
```
will result in the route "http://website.com/api/some_route".

#### API Calls
To authenticate requests, set the header "x-wp-api-key" to the API key defined on the Good REST settings page. Request must be application/x-www-form-urlencoded
```ssh
curl -X GET \
  -H "x-wp-api-key: ${API_KEY}" \
  http://website.com/api/some_route
 ```
 
##### jQuery AJAX API call example
#
```javascript
var postData = { some_data : "some_data" };
var postUrl = 'http://website.com/api/some_route';

$.ajax({
	url: postUrl,
	dataType: "text",
	data: postData,
	type: "GET",
	timeout: 8000,
	beforeSend: function(request) {
		 request.setRequestHeader("x-wp-api-key", apiKey);
	}
})
.fail(function( jqXHR, textStatus, errorThrown) {
	// Do something with error
})
.done(function (data) {
	// Do something with data
});
```