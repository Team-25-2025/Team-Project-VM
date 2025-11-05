<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = trim($_POST['title'] ?? '');

    if ($title !== ''){
        $path = __DIR__ . '/../../../public/data/categories.json';
        if (file_exists($path)) {
        $categories = json_decode(file_get_contents($path), true);
        } else {
        $categories = [];
        }
        if (!is_array($categories)) { //If the array doesn't exist
            $categories = []; //In case it is not working properly
        }
        $ids = array_column($categories, 'id');
        if(!empty($categories)){
            $nextID = max($ids) + 1;
        }
        else{
            $nextID = 1;
        }
        $categories[] = ['id' => $nextID, 'title' => $title];
        file_put_contents($path, json_encode($categories));
        header('Location: /TeamProjectManage/public/index.php/knowledge/categories'); 
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Create Category</title>
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
            <h1>Create a Category</h1>
            <div>
            <form method="post" action="/TeamProjectManage/public/index.php/knowledge/create/categories">
                <label>Category Name:<br>
                <textarea name ="title" rows ="2" cols ="60" required></textarea>
                </label><br><br>
                <button type="submit" class = "btn btn-primary">Submit</button><br>
            </form>
            </div>
            <br>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $title = $_POST['title'];
                echo"<p>You entered: $title$<br><br>";
            }
            ?>
            <div>
            <a href="/TeamProjectManage/public/index.php/knowledge/categories" class = "btn btn-primary">Back to Categories</a>
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
</html>