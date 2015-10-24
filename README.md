# Good REST

Good REST is a WordPress plugin designed to open add REST API functionality to WordPress installations. This plugin is only intended to allow remote requests and not local routing. Features include:

  - Developer defined routes similar to Slim framework format
  - User enabled built-in routes from registerd post types
  - API key authentication
  - Dashboard page for managing plugin settings

### Installation
Download the zip of this repo and paste its contents in your site's plugins folder.

### Developer Instructions
To create routes, define them in the theme's functions file. It's possible to define dynamic routes for GET, POST, DELETE, and PUT requests and send parameters with each.
#### Code examples

##### GET request
#
```php
GoodREST::get("some_route/:id", function ($params) {
	GoodREST::response(json_encode($params));
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

Dillinger uses a number of open source projects to work properly:

* [AngularJS] - HTML enhanced for web apps!
* [Ace Editor] - awesome web-based text editor
* [Marked] - a super fast port of Markdown to JavaScript
* [Twitter Bootstrap] - great UI boilerplate for modern web apps
* [node.js] - evented I/O for the backend
* [Express] - fast node.js network app framework [@tjholowaychuk]
* [Gulp] - the streaming build system
* [keymaster.js] - awesome keyboard handler lib by [@thomasfuchs]
* [jQuery] - duh

And of course Dillinger itself is open source with a [public repository][dill]
 on GitHub.

### Installation

You need Gulp installed globally:

```sh
$ npm i -g gulp
```

```sh
$ git clone [git-repo-url] dillinger
$ cd dillinger
$ npm i -d
$ mkdir -p downloads/files/{md,html,pdf}
$ gulp build --prod
$ NODE_ENV=production node app
```

### Plugins

Dillinger is currently extended with the following plugins

* Dropbox
* Github
* Google Drive
* OneDrive

Readmes, how to use them in your own application can be found here:

* [plugins/dropbox/README.md] [PlDb]
* [plugins/github/README.md] [PlGh]
* [plugins/googledrive/README.md] [PlGd]
* [plugins/onedrive/README.md] [PlOd]

### Development

Want to contribute? Great!

Dillinger uses Gulp + Webpack for fast developing.
Make a change in your file and instantanously see your updates!

Open your favorite Terminal and run these commands.

First Tab:
```sh
$ node app
```

Second Tab:
```sh
$ gulp watch
```

(optional) Third:
```sh
$ karma start
```

### Todos

 - Write Tests
 - Rethink Github Save
 - Add Code Comments
 - Add Night Mode

License
----

MIT


**Free Software, Hell Yeah!**

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does it's job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)


   [dill]: <https://github.com/joemccann/dillinger>
   [git-repo-url]: <https://github.com/joemccann/dillinger.git>
   [john gruber]: <http://daringfireball.net>
   [@thomasfuchs]: <http://twitter.com/thomasfuchs>
   [df1]: <http://daringfireball.net/projects/markdown/>
   [marked]: <https://github.com/chjj/marked>
   [Ace Editor]: <http://ace.ajax.org>
   [node.js]: <http://nodejs.org>
   [Twitter Bootstrap]: <http://twitter.github.com/bootstrap/>
   [keymaster.js]: <https://github.com/madrobby/keymaster>
   [jQuery]: <http://jquery.com>
   [@tjholowaychuk]: <http://twitter.com/tjholowaychuk>
   [express]: <http://expressjs.com>
   [AngularJS]: <http://angularjs.org>
   [Gulp]: <http://gulpjs.com>
   
   [PlDb]: <https://github.com/joemccann/dillinger/tree/master/plugins/dropbox/README.md>
   [PlGh]:  <https://github.com/joemccann/dillinger/tree/master/plugins/github/README.md>
   [PlGd]: <https://github.com/joemccann/dillinger/tree/master/plugins/googledrive/README.md>
   [PlOd]: <https://github.com/joemccann/dillinger/tree/master/plugins/onedrive/README.md>


