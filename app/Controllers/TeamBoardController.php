<?php
namespace App\Controllers;

class TeamBoardController {
  public function index() {
    if ($_SESSION['user']['permission'] == 'manager') {
      view('TeamBoard/team_board_hub_manager.view.php');  
    } elseif ($_SESSION['user']['permission'] == 'teamleader') {
      view('TeamBoard/team_board_teamleader.view.php');
    } elseif ($_SESSION['user']['permission'] == 'employee') {
      view('TeamBoard/team_board_employee.view.php');
    } 
  }
}