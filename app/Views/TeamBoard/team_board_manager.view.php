<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Manager - Team Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style/teamboard/teamboard.view.css">
    <link rel="stylesheet" href="style/nav.css">
</head>

<body>
    <?php view('partials/nav.php') ?>
    <div class="main-content" id="mainContent">
    <!-- Add task popup (hidden) -->
    <div class="popup-overlay" id="addTaskPopup">
        <div class="popup">
            <h3 id="addTaskTitle">Add a new task</h3>
            <form id="add-task-form">
                <label>
                    Task title
                    <input type="text" name="title" id="task-title-popup" maxlength="30" required />
                </label>
                <label>
                    Description
                    <textarea name="description" id="task-desc-popup" rows="4" required></textarea>
                </label>
                <label>
                    Due date
                    <input type="date" name="due" id="task-due-popup" required />
                </label>
                <label>
                    Assign employee
                    <input type="text" name="assignee" id="task-assignee-popup" maxlength="30" required />
                </label>
                <fieldset>
                    <legend>Risk level</legend>
                    <label for="risk-low">
                        <input type="radio" name="risk" value="low" id="risk-low" required>
                        Low
                    </label>
                    <label for="risk-medium">
                        <input type="radio" name="risk" value="medium" id="risk-medium">
                        Medium
                    </label>
                    <label for="risk-high">
                        <input type="radio" name="risk" value="high" id="risk-high">
                        High
                    </label>
                </fieldset>

                <div class="popup-actions">
                    <button type="submit" class="add-task-button">Save</button>
                    <button type="button" id="cancelAddTask">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <button class="sidebar-toggle-inline me-3" id="sidebarToggleInline">
        <i class="fas fa-bars"></i>
    </button>
    <div class="board">
        <h1>Team Board</h1>
        <p>Signed in as Manager</p>
        <button id="teamList" class="team-list-button" type="button">View Team List</button>
        <p>Click a task to see details and updates</p>

        <button id="addTaskButton" class="add-task-button" type="button">Add New Task</button>
        <div class="task-area">
            <p id="EmptyMsg">Tasks will be displayed here. Click "Add New Task" to create a new task.</p>
        </div>

    </div>
    </div>
    <?php requireModule(['teamboard/teamboard.view', 'nav']) ?>
</body>

</html>