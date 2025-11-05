<?php
namespace App\Core\Permission;

class Manager {
  public function handle($keys) {
    if (!in_array($_SESSION["user"]["permission"], $keys)) {
      if ($_SESSION["user"]["permission"] == 'teamleader') {
        header("location: /dashboard");  // redirect if not manager
      } else {
        header('location: /todo');
      }
      
      exit();
    }
  }  
}