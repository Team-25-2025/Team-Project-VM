
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Discussion Forum - Make-It-All</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/discussion/discussion.view.css">
<link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
</head>
<body>
<?php view('partials/nav.php') ?>
<!-- Main content page where all discussions are displayed-->
<div class="main-content" id="mainContent">
    
    <header>
        <button class="sidebar-toggle-inline me-3" id="sidebarToggleInline">
            <i class="fas fa-bars"></i>
        </button>
        <p id="topic">All Posts</p>
        <input type="text" placeholder="Search discussions..." id="search" class="form-control">
        <button id="search-button"><i class="fas fa-search"></i></button>
        <button id="create">Create New Discussion</button>
        <img src="\..\TeamProjectManage/public/images/profile-picture.jpg" alt="Profile" id="pfp">
    </header>
    
    <!-- Modal that allows users to create a new discussion-->
    <div id="create-modal" class="modal" style="display:none;">
        <div class="modal-content">
            <h3>Create New Discussion</h3>
            <input type="text" id="newTitle" placeholder="Discussion Title" class="form-control">
            <textarea id="newDescription" placeholder="Description" class="form-control"></textarea>
            <button id="submitDiscussion" class="btn btn-success">Create</button>
            <button id="cancelCreate" class="btn btn-secondary">Cancel</button>
        </div>
    </div>

    <!-- Panel for viewing a discussion and its comments-->
    <div id="discussion-view" class="panel" style="display:none;">
      <div class="panel-content">
        <h3 id="discussion-title"></h3>
        <p id="discussion-description"></p>
        <div id="discussion-comments" class="mb-2"></div>
        <textarea id="new-comment" placeholder="Add a comment..." class="form-control mb-2"></textarea>
        <button id="submit-comment" class="btn btn-primary">Comment</button>
        <button id="close-view" class="btn btn-secondary">Close</button>
      </div>
    </div>
    
	<!-- Modal for confirming the deletion of a discussion-->
    <div id="delete-modal" class="modal" style="display:none;">
        <div class="modal-content" style="text-align:center;">
            <h4>Are you sure you want to delete this discussion?</h4>
            <button id="confirmDelete" class="btn btn-danger">Yes, Delete</button>
            <button id="cancelDelete" class="btn btn-secondary">Cancel</button>
        </div>
    </div>
    
    <!-- Container where all discussion cards are dynamically rendered -->
    <div id="discussion-container"></div>
</div>

<?php requireModule(['discussion.view', 'nav']) ?>
</body>
</html>