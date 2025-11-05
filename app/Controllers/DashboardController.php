<?php 
namespace App\Controllers;
class DashboardController {
  public function index() {
    if ($_SESSION['user']['permission'] == 'manager') {
      view('dashboard/dashboard_manager.view.php');
    } elseif ($_SESSION['user']['permission'] == 'teamleader') {
    view('dashboard/dashboard_teamleader.view.php');
    }
  }
}