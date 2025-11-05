<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category = trim($_POST['category'] ?? '');

    if ($title !== ''){
        $path = __DIR__ . '/../../../public/data/topics.json';
        if (file_exists($path)) {
        $topics = json_decode(file_get_contents($path), true);
        } else {
        $topics = [];
        }
        if (!is_array($topics)) { //If the array doesn't exist
            $topics = []; //In case it is not working properly
        }
        $ids = array_column($topics, 'id');
        if(!empty($ids)){
            $nextID = max($ids) + 1;
        }
        else{
            $nextID = 1;
        }
        $topics[] = ['id' => $nextID, 'title' => $title, 'content' => $content, 'category' => $category];
        file_put_contents($path, json_encode($topics));
        header('Location: /TeamProjectManage/public/index.php/knowledge/categories'); 
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Create Topic</title>
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
            <div class = "card bm-3 p-3 shadow-sm">
            <div class = "card-body">
            <h1>Create a Topic</h1>
            <div class = "card">
            <form method="post">
                <label>Title:<br>
                <input type ="text" name ="title" required>
                </label><br><br>
                <label>Description:<br>
                <textarea name ="content" rows ="2" cols ="60" required></textarea>
                </label><br><br>
                <label>Category (must match the name of an existing category):<br>
                <textarea name ="category" rows ="1" cols ="60" required></textarea>
                </label><br><br>
                <button type="submit" class = "btn btn-primary">Submit</button><br><br>
            </form>
            </div>
            <br>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $title = $_POST['title'];
                $content = $_POST['content'];
                $category = $_POST['category'];
                echo"<p>You entered: $title: $content<br><br>";
            }
            ?>
            <div>
            <a href="/TeamProjectManage/public/index.php/knowledge" class = "btn btn-primary" style = "text-align: left">Back to Topics</a>
            </div>
            </div>
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