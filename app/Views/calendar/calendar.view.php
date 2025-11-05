<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meeting Calendar</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/calendar/calendar.view.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
</head>
<body>

<?php view('partials/nav.php') ?>

<div class="main-content" id="mainContent">
    <div class="d-flex">
        <button class="sidebar-toggle-inline me-3" id="sidebarToggleInline">
            <i class="fas fa-bars"></i>
        </button>
         <h1>Meeting Calendar</h1>
    </div>
        <div id="calendar">
            <div id="calendarHeader" class="calendarHeader">
                <button type="button" id="prevMonth">Prev Month</button>
                <h2 id="monthYear"></h2>
                <button type="button" id="nextMonth">Next Month</button>
            </div>
            <div id="weekdays" class="weekdays">
                <div>Sunday</div>
                <div>Monday</div>
                <div>Tuesday</div>
                <div>Wednesday</div>
                <div>Thursday</div>
                <div>Friday</div>
                <div>Saturday</div>
            </div>
            <div id="calendarContent" class="calendarContent"></div>
        </div>
        <div id="newEventForm" class="newEventForm">
            <div>
                <label for="date">Date<sup>*</sup>:</label>
                <input type="date" id="date">
                <label for="time">Time<sup>*</sup>:</label>
                <input type="time" id="time"><br>
                <label for="title">Title<sup>*</sup>:</label>
                <input type="text" id="title"><br>
                <label for="description">Description:</label>
                <input type="text" id="description"><br>
                <label for="url">Url:</label>
                <input type="url" id="url"><br>
                <label for="location">Location:</label>
                <input type="text" id="location"><br>
                <label for="tags">Tags:</label>
                <input type="text" id="tags"><br>
                <label for="color">Colour:</label>
                <input type="color" id="color"><br>
                <p><sup>*</sup>are required fields, the rest are optional.</p>
                <button id = "addEvent" class = "addEvent">Add Event</button>
            </div>
        </div>
        <div class="eventListHeading"><h2>Events for &nbsp;</h2><h2 id="eventMonthYear"></h2></div>
        <div id="eventList" class="eventList">
            <div id="eventListContent"></div>
        </div>
        
<?php requireModule(['nav', 'calendar.view']) ?>
</body>
</html>