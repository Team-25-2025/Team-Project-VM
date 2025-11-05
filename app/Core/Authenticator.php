<?php

namespace App\Core;

class Authenticator {
  public function attemp ($email, $password) {
    // $db = App::resolve("Core\Database");

    // $user = $db->query("SELECT * FROM users WHERE email = :email", ["email" => $email])->fetch();


    // if ($user) {
    //   if (password_verify($password, $user["password"])) {
    //     Authenticator::login(["email" => $email]);
    //     return true;
    //   }  
    // }
    // return false; 
    $config = require base_path('config.php');
    $users = $config['users'];
    foreach($users as $user) {    
      if ($email == $user['email']) {
        if ($password == $user['password']) {
          $permission = $user['permission'];
          Authenticator::login(["email" => $email, "permission" => $permission]);
          return true;
        } else {
          continue;
        }
      }
    }

    return false;
  }
  public static function login($user) {
    $_SESSION["user"] = [
    "email" => $user["email"],
    "permission" => $user["permission"] ?? null
    ];
    session_regenerate_id(true);
}
  public static function logout() {
    Session::destroy();
  }
}

?>