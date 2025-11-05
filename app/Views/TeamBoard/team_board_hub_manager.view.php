<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Manager Dashboard - Team Board Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="\..\TeamProjectManage/public/style/teamboard/teamboard.view.css">
    <link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
</head>
<body>
    <?php view('partials/nav.php') ?>
    <div class="main-content" id="mainContent">
    <!-- Add project popup (hidden) -->
    <div class="popup-overlay" id="addProjectPopup">
        <div class="popup">
            <h3 id="addProjectTitle">Create a new project</h3>
            <form id="add-project-form">
                <label>
                    Project name
                    <input type="text" name="projectName" id="project-name-popup" maxlength="50" required />
                </label>
                <label>
                    Project description
                    <textarea name="projectDescription" id="project-desc-popup" rows="4" required></textarea>
                </label>
                <label>
                    Appoint team leader
                    <input type="text" name="teamLeader" id="team-leader-popup" maxlength="30" required />
                </label>
                <label>
                    Start date
                    <input type="date" name="startDate" id="project-start-popup" required />
                </label>
                <label>
                    Target end date
                    <input type="date" name="endDate" id="project-end-popup" required />
                </label>

                <div class="popup-actions">
                    <button type="submit" class="add-project-button">Save</button>
                    <button type="button" id="cancelAddProject">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <button class="sidebar-toggle-inline me-3" id="sidebarToggleInline">
        <i class="fas fa-bars"></i>
    </button>
    <div class="board">
        <h1>Manager Dashboard</h1>
        <p>Signed in as Manager</p>

        <div class="manager-controls">
            <button id="addProjectButton" class="add-task-button" type="button">Create New Project</button>
        </div>

        <div class="projects-section">
            <div class="projects-area">
                <p id="EmptyMsg-Projects">No projects created yet. Click "Create New Project" to start.</p>
            </div>
        </div>
    </div>
    </div>
    <?php requireModule(['teamboard/admin', 'nav']) ?>
</body>
</html>