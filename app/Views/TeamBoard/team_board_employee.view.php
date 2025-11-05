<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Team Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="\..\TeamProjectManage/public/style/teamboard/teamboard.view.css">
    <link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
</head>

<body>
    <?php view('partials/nav.php') ?>
    <div class="main-content" id="mainContent">
        <button class="sidebar-toggle-inline me-3" id="sidebarToggleInline">
            <i class="fas fa-bars"></i>
        </button>
        <div class="board">
            
            <h1>Team Board</h1>
            <p>Signed in as Employee</p>
            <button id="teamList" class="team-list-button" type="button">View Team List</button>
            <p>Click a task to see details and updates</p>

            <div class="task-area">
                <p id="EmptyMsg">Tasks will be displayed here once added by the manager.</p>
            </div>

        </div>
    </div>
    <?php requireModule(['teamboard/teamboard.view', 'nav']) ?>
</body>
</html>