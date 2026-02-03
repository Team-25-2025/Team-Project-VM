<?php
namespace App\Controllers;

class TeamBoardController {
  public function index()
  {
    if (!isset($_GET['teamId'])) {
      die("No team selected.");
    }
    $teamId = $_GET['teamId'];
    // Pass $teamId to the view
    view('projectsAndTeamBoard/teamboard.php', ['teamId' => $teamId]);
  }

}
?>