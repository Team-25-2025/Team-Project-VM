<?php
namespace App\Core\Permission;

class TeamLeader {
  public function handle($keys) {
    if (!in_array($_SESSION["user"]["permission"], $keys)) {
      if ($_SESSION["user"]["permission"] == 'manager') {
        header("location: /dashboard");  // redirect if not manager
      } else {
        header('location: /todo');
      }
      exit();
    }
  }  
}