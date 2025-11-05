<?php 
use App\Core\Response;
use App\Core\Session;
function dd($value) {
  echo "<pre>" . var_dump($value) . "<pre>";
  die();
}
function urlIs($value) {
  return $_SERVER["REQUEST_URI"] == $value;
}
function abort($code = 404) {
  http_response_code($code);
  require base_path("views/{$code}.php");
  die();
}
function authorize($condition, $status = Response::FORBIDEN) {
  if (!$condition) {
    abort($status);
  }
}
function base_path($path) {
  return BASE_PATH . $path;
}
function view ($path, $attributes = []) {
  extract ($attributes);
  require base_path("app/Views/" . $path);
}
function requireStyle ($attributes = []) {
  require base_path("app/Views/partials/header.php");
}
function requireModule ($attributes = []) {
  require base_path("app/Views/partials/footer.php");
}
function redirect($path) {
  header("location: {$path}");
  exit();
}
function old($key, $default = '') {
  return Session::get("old")[$key] ?? $default;
}
function errors($key, $default = '') {
  return Session::get("errors")[$key] ?? $default;
}
?>