<?php
namespace App\Controllers;

class AnalyticsController {
  public function index() {
    if ($_SESSION['user']['permission'] == 'teamleader') {
      view('analytics/analytics_teamleader.php');
    } 
    elseif ($_SESSION['user']['permission'] == 'employee'){
      view('analytics/analytics_employee.php');
    }
  }
}