<?php
$topicId = $_GET['topicId'] ?? null;
$path2 = __DIR__ . '/../../../public/data/posts.json';
if (!file_exists($path2)){
    file_put_contents($path2, '[]');
    //In case posts.json does not exist yet
}
$posts = json_decode(file_get_contents($path2), true);
if(!is_array($posts)){
    $posts = []; //In case the array doesn't exist yet
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newPost'])) {
    //The isset above is for when we add comments later, so we know it is from the new post form
    $postTitle = trim($_POST['postTitle']);
    $author = trim($_POST['author']);
    $message = trim($_POST['message']);
    $topicId = trim($_POST['topicId']);
    if ($author !== '' && $message !== ''){
        if (count($posts) > 0){
            $newId = max(array_column($posts, 'id')) + 1;
        }
        else{
            $newId = 1;
        }
        $newPost = ['id' => $newId, 'topicId' => $topicId, 'postTitle' => $postTitle, 'author' => $author, 'message' => $message, 'date' => date('d-m-Y H:i')];
        $posts[] = $newPost;
        file_put_contents($path2, json_encode($posts));
        header("Location: /knowledge/viewtopic?id=".$topicId);
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title> Create Post </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="\..\TeamProjectManage/public/style/knowledge/knowledge.view.css">
        <link rel="stylesheet" href="\..\TeamProjectManage/public/style/mytodo/todo.view.css">
        <link rel="stylesheet" href="\..\TeamProjectManage/public/style/nav.css">
    </head>
        <body>
            <?php view('partials/nav.php') ?>
            <header>
                <div class="container p-4">
                <h3> Knowledge Manager </h3>
                </div>
            </header>

            <main>
            <div class = "container p-4">
            <div class = "card mb-3 p-3 shadow-sm">
            <div class = "card-body">
            <h3> Add a new post: </h3>
            <div>
            <form method = "post">
                <input type = "hidden" name = "topicId" value = <?php echo $_GET['topicId'];?>>
                <label> Post Title: <br>
                <input type = "text" name = "postTitle" required>
                </label> <br><br>
                <label> Author Name: <br>
                <input type = "text" name = "author" required>
                </label> <br><br>
                <label> Main Body: <br>
                <textarea name = "message" rows = "20" cols = "50" required></textarea>
                </label> <br><br>
                <button type = "submit" name = "newPost" class = "btn btn-primary">Submit</button><br><br>
            </form>
            </div>
            <div>
            <a class = "btn btn-primary" href="/TeamProjectManage/public/index.php/knowledge/viewtopic?id=<?php echo $topicId; ?>">Back to Topic</a>
            </div>
            </div>
            </main>

            <footer>
                <div class = "container">
                    <p> Team 25 </p>
                </div>
            </footer>
        </body>
        <?php requireModule(['nav']) ?>
</html>