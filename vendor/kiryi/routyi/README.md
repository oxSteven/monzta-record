# Kiryi's ROUTYI
A routing mechanism for web applications.

## Installation
```bash
composer require kiryi/routyi
```

## Usage
First set up the [routing table](#the-routing-table). Then use:
```php
$routyi = new \Kiryi\Routyi\Router());
$routyi->route();
```
All endpoint classes have to implement the `Kiryi\Routyi\EndpointInterface` and so must have a method `run(array $params)`.

## Constructor Definition
```php
__construct(?string $namespace = null, ?string $routingTableFilepath = null, ?string $configFilepath = null)
```
### Parameters
**namespace**  
Optional namespace your routing table endpoints start with. If no namespace is provided, endpoints have to be configured with their fully qualified namespace in routing table.  

**routingTableFilepath**  
Optional filepath to the routing table INI file. It is relative to your project's root directory. If no filepath is provided, default (*config/routing.ini*) is used ([more information](#the-routing-table)).  

**configFilepath**  
Optional filepath to a configuration INI file. It is relative to your project's root directory. If no filepath is provided, default (*config/routyi.ini*) is used. This filepath is only relevant if you are using a subdirectory ([more information](#using-a-subdirectory)).

## Method Definition *route*
```php
route(): void
```

## The Routing Table
The routing table is an INI file consisting of routes (key) and corresponding endpoints (value). The default filepath is *config/routing.ini*. If you want to change this, see constructor parameter `string $rountingTableFilepath`.

### Basic Structure
```ini
/ = Fully\Qualified\Namespace\DefaultController
/foo = Fully\Qualified\Namespace\FooController
/foo/bar = Fully\Qualified\Namespace\BarController
```
The single slash '/' is the default controller. It is used as home page and everytime no actual route is found.

If you want to configure a namespace for the endpoints, see constructor parameter `string $namespace` and the provided [example](#example).

## Routes Parameters
The URL will be processed from the longest possible route to the shortest. As soon as a route from the routing table matches, everything after the route part is considered parameters and gets put into an array, which is passed to the `run` method.

## Using a Subdirectory
If you are using a subdirectory for your web application, you have to specify a configuration INI file with the following content:
```ini
[routyi]
subDir = {YOURSUBDIRECTORY}
```

The default filepath is *config/routyi.ini*. If you want to change this, see constructor parameter `string $configFilepath`.

## Example
*configuration/routes.ini*
```ini
/ = HomeController
/about = AboutController
```
*src/Bootstrap.php*
```php
(new \Kiryi\Routyi\Router('MyProject\\Controller\\', 'configuration/routes.ini'))->route();
```
URL *mydomain.com* will route to `MyProject\Controller\HomeController`.  
URL *mydomain.com/about* will route to `MyProject\Controller\AboutController`.  
URL *mydomain.com/wrong/route* will route to `MyProject\Controller\HomeController`. Since */wrong/route* is not a matching route, the part is interpreted as parameters and passed to the `run` method of the `HomeController`.
