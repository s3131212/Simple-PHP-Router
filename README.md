# PHP Router

This is a simple PHP Routing Class.  

## Usage

### Call Function
There are several ways to call functions or methods.  
Most importantly, create the `Router` object first.

```php
$router = new Router;
```

#### Function

The standard way is to create an array and specify the function name to `func` and function parameters, if exist, to `parameters`. 

```php
$router->get('/print', array(
	'func' => 'add',
	'parameters' => array(1, 2) //Call add(1, 2)
));
```
P.S. If there is only one parameter, `string` is also accepted.

If no parameter needed, simply put the function name in to the blank.

```php
$router->get('/phpinfo', 'phpinfo'); //Call phpinfo()
```

#### Method

Similar to calling a function, assign the class name and method name to `func` in an array. Keep in mind that class name must be a variable pointed to the declared object.

```php
$router->get('/text', array(
	'func' => array($Controller, 'text'), //Call $Controller->text, $Controller must be declared
	'parameters' => '123'
));
```
Call a static method through `Class::Method`. 

```php
$router->get('/hello/world', array(
	'func' => 'Controller::helloworld' //Call Controller::helloworld
));
```

#### Anonymous Function (Closure)

Anonymous function is awesome, give it a try!

```php
$router->get('/echo', function(){
	echo $_GET['t'];
});
```

### Routing
```php
$router = new Router;

//Match "/hello/world"
$router->get('/hello/world', ...);

//Match "/path", "/paath", "/paaaaath", and so on
$router->get('/pa+th', ...);

//Match "/path", "/pa123th", "/paabcdeth", and so on
$router->get('/pa\*th', ...);

//Match "/abe" and "/abcde"
$router->get('/ab(cd)e', ...);

//Pattern started with /^\/ and ended with $/ wil be served as regular expression
$router->get('/^\/\d+$/', ...);
```

### URL Parameters

In some cases, you might need to set some parts of the URL as variables, or parameters. Wrap the parameter name between '{' and '}'. 

```php
$router->get('/{var1}/{var2}/test{var3}', ...);
```

There are two ways to access the values of the parameters. Use `get_URL_parameter` method or assign parameters to closure.

```php
$router->get('/para/{var1}/{var2}', function($var1, $var2){
    //PS. When using get_URL_parameter to access the values, $var1 and $var2 are not necessary.
    
    global $router;
    echo 'via get_URL_parameter():';
    echo '<br>var1:' .$router->get_URL_parameter('var1');
    echo "<br>var2:" .$router->get_URL_parameter('var2');

    echo '<br>via closure parameters:';
    echo '<br>var1:' .$var1;
    echo "<br>var2:" .$var2;
});
```

### HTTP Method
Only `GET` and `POST` are allowed, `PUT`, `DELETE`, and `PATCH` have not yet supported.

```php
//GET only
$router->get('/form', array(
	'func' => array($Controller, 'form_get')
));

//POST only
$router->post('/form', array(
	'func' => array($Controller, 'form_post')
));

//GET and POST
$router->any('/form', array(
	'func' => array($Controller, 'form_post')
));
```

### Catch Exception

Triggered when no suitable routing pattern is found.

```php
$router->catch_exception(function(){
	echo 'no suitable routing pattern';
});
``` 

### Other

If any base or prefix of the path exist, use `setBase()`.

```php
$router->setBase('/base')

$router->get('/test', ...) //Match /base/test
```

Get current URL through `get_URL()`

```php
$router->get_URL(); //Without parameters
$router->get_URL(true); //With parameters

```

## Configuration

### Apache
Create `.htaccess` in root directory (or project directory) and put the following code to the file.

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [NC,L,QSA]
```

PS. Make sure that `mod_rewrite ` is enabled.

### Nginx
Find nginx config file, and add following code to `server` section.

```
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```
