<?php
$path = __DIR__ . '/../../../public/data/topics.json';
if (file_exists($path)) {
  $topics = json_decode(file_get_contents($path), true);
} else {
  $topics = [];
}
if (!is_array($topics)) { //If the array doesn't exist
    $topics = []; //In case it is not working properly
}
$category = isset($_GET['category']) ? urldecode($_GET['category']) : null;
if ($category){
    $filteredTopics = [];
    foreach ($topics as $t){
        if (isset($t['category']) && $t['category'] === $category){
            $filteredTopics[] = $t;
        }
    }
    $topics = $filteredTopics;
}
usort($topics, function($a, $b){
    return strcmp($a['title'], $b['title']);
});
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Topics</title>
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
            <h1>Topics</h1>
            <div>
            <h4><a href="/TeamProjectManage/public/index.php/knowledge/create/topic" class = "btn btn-primary">Create new topic</a></h4>
            </div>
            <br>
            <form method = "get" class = "d-flex mb-3" style = "margin-bottom: 16px;">
                <input type = "hidden" name = "category" value = "<?php echo htmlspecialchars($_GET['category'] ?? ''); ?>">
                <input type = "text" name = "search" placeholder = "Search topics..." size = "40" value = "<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                <button type = "Submit" class = "btn btn-primary ms-2"> Search </button>
            </form>
            <a href = "<?php echo '/TeamProjectManage/public/index.php/knowledge?category='.urlencode($_GET['category'] ?? ''); ?>" class = "btn btn-outline-secondary"> Clear search</a>
            <br><br>
            <?php
            if (empty($topics)){
                echo "<p> No topics yet.</p>";
                echo "<div>";
                echo "<p> <a href='/TeamProjectManage/public/index.php/knowledge/categories' class = 'btn btn-primary'> Back to Categories </a> </p>";
                echo "</div>";
            }
            else {
               $search = strtolower(trim($_GET['search'] ?? ''));
                if ($search !== '') {
                    $ft2 = [];
                    foreach ($topics as $t){
                        $title1 = strtolower($t['title'] ?? '');
                        $content1 = strtolower($t['content'] ?? '');
                        if (strpos($title1, $search) !== false || strpos($content1, $search) !== false) {
                            $ft2[] = $t;
                        }
                    }
                    $topics = $ft2;
                    usort($topics, function($a, $b){
                    return strcmp($a['title'], $b['title']);
                    });
                }
                foreach ($topics as $t) {
                    echo "<div class = 'card mb-3 p-3 shadow-sm'>
                    <div class  ='card-body'>
                    <h3 class = 'card-title'>".htmlspecialchars($t['title'])."</h3>
                    <p class = 'card-content'>".htmlspecialchars($t['content'])."</p>
                    <a class = 'btn btn-outline-primary' href = '/TeamProjectManage/public/index.php/knowledge/viewtopic?id=".$t['id']."'>View Topic</a>
                    </div>
                    </div>";
                }
                echo "<div";
                echo "<p> <a href='/TeamProjectManage/public/index.php/knowledge/categories' class = 'btn btn-primary'> Back to Categories </a> </p>";
                echo "</div>";
            }
            ?>
            </div>
        </div>
        </div>
        </main>

        <footer>
            <div class = "container p-4">
                <p> Team 25 </p>
            </div>
        </footer>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
        <?php requireModule(['nav']) ?>
        </body>
</html>