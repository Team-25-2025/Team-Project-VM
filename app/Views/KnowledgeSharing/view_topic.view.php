<?php
$path = __DIR__ . '/../../../public/data/topics.json';
$topics = json_decode(file_get_contents($path), true);
$id = $_GET['id'] ?? null;
$topic = null;
if ($id !== null){
    foreach($topics as $t){
        if ($t['id'] == $id){
            $topic = $t;
            break;
        }
    }
}
$path2 = __DIR__ . '/../../../public/data/posts.json';
if (!file_exists($path2)){
    file_put_contents($path2, '[]');
    //In case posts.json does not exist yet
}
$posts = json_decode(file_get_contents($path2), true);
if(!is_array($posts)){
    $posts = []; //In case the array doesn't exist yet
}

$topicPosts = [];
if ($topic){
    foreach ($posts as $p){
        if ($p['topicId'] == $topic['id']){
            $topicPosts[] = $p;
        }
    }
}
usort($topicPosts, function($a,$b){
    return $b['id'] <=> $a['id'];
});

$commentsPath = 'data/comments.json';
if (!file_exists($commentsPath)){
    file_put_contents($commentsPath, '[]');
}
$comments = json_decode(file_get_contents($commentsPath), true);
if (!is_array($comments)){
    $comments = [];
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["newComment"])){
    $postId = $_POST["postId"];
    $author = trim($_POST["author"]);
    $content = trim($_POST["content"]);

    if ($author !== "" && $content !== ""){
        $newId = count($comments) > 0 ? max(array_column($comments, "id")) + 1 : 1;
        $newComment = [
            "id" => $newId,
            "postId" => $postId,
            "author" => $author,
            "content" => $content,
            "date" => date("d-m-Y H:i")
        ];
        $comments[] = $newComment;
        file_put_contents($commentsPath, json_encode($comments));
        header("Location: " . $_SERVER["REQUEST_URI"]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Posts</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="\..\TeamProjectManage/public/style/knowledge/knowledge.view.css">
        <link rel="stylesheet" href="\..\TeamProjectManage/public/style/mytodo/todo.view.css">
        <link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
    </head>
        <body>
             <?php view('partials/nav.php') ?>           

            <div class="main-content">
            <nav class="navbar bg-light px-4">
            <div class="container-fluid p-4">
            <div class="navbar-brand">
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
            <?php
            if($topic){
                echo "<h1>".htmlspecialchars($topic['title'])."</h1>";
                if (!empty($topicPosts)){
                    ?>
                    <div>
                    <h4><a class = "btn btn-primary" href ="/TeamProjectManage/public/index.php/knowledge/create/post?topicId=<?php echo $topic['id'];?>"> Create Post </a></h4>
                    </div>
                    <br>
                    <form method = "get" class = "d-flex mb-3" style = "margin-bottom: 16px; max-width: 500px;">
                        <input type = "hidden" name = "id" value = "<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>">
                        <input type = "text" name = "search" placeholder = "Search posts..." size = "40" value = "<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                        <button type = "Submit" class = "btn btn-primary ms-2"> Search </button>
                    </form>
                    <a href = "<?php echo '/TeamProjectManage/public/index.php/knowledge/viewtopic?id='.urlencode($_GET['id'] ?? ''); ?>" class = "btn btn-outline-secondary"> Clear search</a>
                    <br><br>
                    <?php 
                    $search = strtolower(trim($_GET['search'] ?? ''));
                    if ($search !== ''){
                        $filteredPosts = [];
                        foreach($topicPosts as $p){
                            $title1 = strtolower($p['postTitle'] ?? '');
                            $author1 = strtolower($p['author'] ?? '');
                            $message1 = strtolower($p['message'] ?? '');
                            if (strpos($title1, $search) !== false || strpos($author1, $search) !== false || strpos($message1, $search) !== false){
                                $filteredPosts[] = $p;
                            }
                        }
                        $topicPosts = $filteredPosts;
                    }
                    echo "<h2 style = 'text-align: left'>Posts: </h2>";
                    foreach($topicPosts as $p) {
                        echo "<div class = 'card mb-3 p-3 shadpw-sm'>";
                        echo "<div class = 'card-body'>";
                        echo "<h3 class = 'card-title'>".htmlspecialchars($p['postTitle'])."</h3>";
                        echo "<p>By ".htmlspecialchars($p['author'])." on ".htmlspecialchars($p['date'])."</p><br><br>";
                        echo "<p>".nl2br(htmlspecialchars($p['message']))."</p>";
                        $postComments = [];
                        foreach ($comments as $c){
                            if ($c['postId'] == $p['id']){
                                $postComments[] = $c;
                            }
                        }
                        usort($postComments, function($a,$b){
                            return $b['id'] <=> $a['id'];
                        });
                        echo "<button class = 'btn btn-outline-primary' onclick='toggleComments(this, ".$p['id'].")'>Show Comments</button>";
                        echo "<div id = 'hideComments".$p['id']."' style = 'display: none; margin-top: 10px;'>";
                        if (!empty($postComments)){
                            foreach($postComments as $pc){
                                echo "<div class = 'comment'>";
                                echo "<h5>".htmlspecialchars($pc['author'])." on ".htmlspecialchars($pc['date'])."</h5>";
                                echo "<p>".nl2br(htmlspecialchars($pc['content']))."</p>";
                                echo "</div>";
                            }
                        }
                        else{
                            echo "<p> No comments yet</p>";
                        }
                        echo "<button class = 'btn btn-outline-primary' onclick='toggleForm(this, ".$p['id'].")'>Add Comment</button>";
                        echo "<div id = 'hideForm".$p['id']."' style = 'display: none;'>";
                        echo "<form method = 'post' class = 'd-flex mb-3' style = 'margin-top: 10px;'>
                        <input type = 'hidden' name = 'postId' value = '".$p['id']."'>
                        <label>Name: <br>
                        <input type = 'text' name = 'author' required>
                        </label><br><br>
                        <label>Comment: <br>
                        <textarea name = 'content' rows = '5' cols = '60' required></textarea>
                        <button type = 'submit' name = 'newComment' class = 'btn btn-outline-primary ms-2'>Add Comment </button>
                        </form>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        }
                    }
                    echo "<div";
                    echo "<p> <a class = 'btn btn-primary' href='/TeamProjectManage/public/index.php/knowledge?category=".urlencode($topic['category'])."'> Back to topics </a> </p>";
                    echo "</div>";
                } 
                else {
                    echo "<p> Topic not found. </p>";
                    echo "<div";
                    echo "<p> <a href='/TeamProjectManage/public/index.php/knowledge' class = 'btn btn-primary'> Back to topics </a> </p>";
                    echo "</div>";
                }
            ?>
            </div>
            </main>
            <footer>
                <div class = "container">
                    <p> Team 25 </p>
                </div>
            </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
        <?php requireModule(['nav']) ?>
        <script>
            function toggleComments(button, id) {
                const section = document.getElementById("hideComments" + id);
                if (section.style.display === "none") {
                    section.style.display = "block";
                    button.textContent = "Hide Comments";
                } else {
                    section.style.display = "none";
                    button.textContent = "Show Comments";
                }
            }

            function toggleForm(button, id) {
                const form = document.getElementById("hideForm" + id);
                if (form.style.display === "none") {
                    form.style.display = "block";
                    button.textContent = "Cancel";
                } else {
                    form.style.display = "none";
                    button.textContent = "Add Comment";
                }
            }
            </script>
        </body>
</html>
    