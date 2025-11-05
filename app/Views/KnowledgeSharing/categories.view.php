<?php
$path = __DIR__ . '/../../../public/data/categories.json';
if (file_exists($path)) {
  $categories = json_decode(file_get_contents($path), true);
} else {
  $categories = [];
}
if (!is_array($categories)) { //If the array doesn't exist
    $categories = []; //In case it is not working properly
}
usort($categories, function($a, $b){
    return strcmp($a['title'], $b['title']);
});
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Categories</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="\..\TeamProjectManage/public/style/knowledge/knowledge.view.css">
        <link rel="stylesheet" href="\..\TeamProjectManage/public/style/mytodo/todo.view.css">
        <link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
    </head>
        <body>

            <?php view('partials/nav.php') ?>


        
            <div class="main-content" id="mainContent">
            <nav class="navbar bg-light px-4">
            <div class="container-fluid p-4">
            <div class="navbar-brand d-flex">
                <button class="sidebar-toggle-inline me-3" id="sidebarToggleInline">
                    <i class="fas fa-bars"></i>
                </button>
                <h3> Knowledge Manager </h3>
            </div>
            </div>
            </nav>
            
            <header>
            </header>

            <main>
            <div class = "container-fluid p-4">
            <div class = "card mb-3 p-3 shadow-sm">
            <div class = "card-body">
            <h1>Categories</h1>
            <div>
            <h4><a href="/TeamProjectManage/public/index.php/knowledge/create/categories" class = "btn btn-primary">Create new category</a></h4>
            </div>
            <br>
            <form method = "get" class = "d-flex mb-3" style = "margin-bottom: 16px; max-width: 500px;" class = "form-control">
                <input type = "text" name = "search" placeholder = "Search categories..." size = "40" value = "<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                <button type = "Submit" class = "btn btn-primary ms-2"> Search </button>
            </form>
          
            <a href = "/TeamProjectManage/public/index.php/knowledge/categories" class = "btn btn-outline-secondary"> Clear search</a>  
            <br><br>
            <?php
            if (empty($categories)){
                echo "<p> No categories yet.</p>";
            }
            else {
                $search = strtolower(trim($_GET['search'] ?? ''));
                if ($search !== '') {
                    $filteredCategories = [];
                    foreach ($categories as $c){
                        $title1 = strtolower($c['title'] ?? '');
                        if (strpos($title1, $search) !== false) {
                            $filteredCategories[] = $c;
                        }
                    }
                    $categories = $filteredCategories;
                    usort($categories, function($a, $b){
                    return strcmp($a['title'], $b['title']);
                    });
                }
                foreach ($categories as $c) {
                    echo "<div class = 'card mb-3 p-3 shadow-sm'>
                    <div class = 'card-body'>
                    <h3 class = 'card-title'>".htmlspecialchars($c['title'])."</h3>
                    <a class = 'btn btn-outline-primary' href = '/TeamProjectManage/public/index.php/knowledge?category=".urlencode($c['title'])."'>View Category</a>
                    </div>
                    </div>";
                }
            }
            ?>
            </div>
        </div>
        </div>
        </main>

        <footer>
            <div class = "container-fluid p-4">
                <p> Team 25 </p>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
        <?php requireModule(['nav']) ?>
        </body>
</html>