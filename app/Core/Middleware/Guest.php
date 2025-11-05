<?php

namespace App\Core\Middleware;

class Guest {
  public function handle() {
    if ($_SESSION["user"] ?? false) {
      header("location: /TeamProjectManage/public/index.php/todo");
      exit();
    }
  }
}

?>