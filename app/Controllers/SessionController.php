<?php 
namespace App\Controllers;
use App\Http\Forms\LoginForm;
use App\Core\Authenticator;
use App\Core\Session;

class SessionController {
  public function index() {
    view('session/create.view.php', ["errors" => Session::get("errors") ?? []]);
  }
  public function store () {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $form = LoginForm::validate(["email" => $email, "password" => $password]);

    $sighnedIn = (new Authenticator)->attemp($email, $password);

    if (!$sighnedIn) {
      $form->error("email", "No matching account found for that email and current password")->throw();
    } 

    if ($_SESSION['user']['permission'] == 'manager' || $_SESSION['user']['permission'] == 'teamleader') {
      redirect('/TeamProjectManage/public/index.php/dashboard');
    } else {
      redirect('/TeamProjectManage/public/index.php/todo');
    }
    
  }
  public function destroy () {
    Authenticator::logout();

    header("location: /TeamProjectManage/public/");
    exit();
  }
}