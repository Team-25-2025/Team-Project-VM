<?php
namespace App\Controllers;

class CalendarController {
  public function index() {
    view('calendar/calendar.view.php');
  }
  public function saveEvents() {
    view('calendar/SaveEvents.php');
  }
  public function loadEvents() {
    view('calendar/LoadEvents.php');
  }
}