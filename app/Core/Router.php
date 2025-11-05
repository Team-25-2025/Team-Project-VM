<?php 
namespace App\Core;


use App\Core\Middleware\Middleware;
use App\Core\Permission\Permission;

class Router {
  protected $routes = [];
  public function add($method, $uri, $controller) {
    $this->routes[] = [
      "uri" => $uri,
      "controller" => $controller,
      "method" => $method,
      "middleware" => null,
      "permission" => []
    ];
    return $this;
  }
  public function get($uri, $controller) {
    return $this->add("GET", $uri, $controller);
  }
  public function post($uri, $controller) {
    return $this->add("POST", $uri, $controller);
  }
  public function delete($uri, $controller) {
    return $this->add("DELETE", $uri, $controller);
  }
  public function patch($uri, $controller) {
    return $this->add("PATCH", $uri, $controller);
  }
  public function put($uri, $controller) {
    return $this->add("PUT", $uri, $controller);
  }
  public function only($key) {
    $this->routes[array_key_last($this->routes)]["middleware"] = $key;
    return $this;
  }
  public function perms(array $perms) {
    $this->routes[array_key_last($this->routes)]["permission"] = $perms;
    return $this;
  }
  public function route($uri, $method) {
    foreach ($this->routes as $route) {
      if ($route["uri"] == $uri && $route["method"] == strtoupper($method)) {

        Middleware::resolve($route['middleware']);
        Permission::resolve($route['permission']); //need to loop until the end and use sessions

        [$class, $method] = explode('@', string: $route["controller"]);

        if (class_exists($class) && method_exists($class, $method)) {
            return (new $class)->$method();
        }
      }
    }

    $this->abort();
  }
  protected function abort($code = 404) {
  http_response_code($code);
  require base_path("Views/{$code}.php");
  die();
  }

  public function previousURI() {
    //add eception for /flight -> /
    return $_SERVER["HTTP_REFERER"];
  }
}




?>