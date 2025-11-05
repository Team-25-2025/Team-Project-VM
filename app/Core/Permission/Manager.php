<?php
namespace App\Core\Permission;

class Manager {
  public function handle($keys) {
    if (!in_array($_SESSION["user"]["permission"], $keys)) {
      if ($_SESSION["user"]["permission"] == 'teamleader') {
        header("location: /TeamProjectManage/public/index.php/dashboard");  // redirect if not manager
      } else {
        header('location: /TeamProjectManage/public/index.php/todo');
      }
      
      exit();
    }
  }  
}