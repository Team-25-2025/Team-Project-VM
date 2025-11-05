<?php
namespace App\Core\Permission;

class Employee {
  public function handle($keys) {
    if (!in_array($_SESSION["user"]["permission"], $keys)) {
      header("location: /TeamProjectManage/public/index.php/dashboard");  // redirect if not employee
      exit();
    }
  }  
}