<?php
include(dirname(__FILE__)."/../database/db.php");
/*include(dirname(__FILE__)."/../helpers/error_info.php");*/

if (!$_SESSION) {
    header('location: ' . BASE_URL . 'auth/auth_form.php');
}
$errorMsg = [];
$id = '';
$title = '';
$content = '';
$img = '';
$category = '';



//Categories listing
$categories = selectAll('categories');
$articles = selectAll('articles');
$articlesAdm = selectAllFromArticlesWithUsers('articles', 'users');


//Article create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_article'])) {
    //Need function
    if (!empty($_FILES['img']['name'])) {
        $imgName = time() . "_" . $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileType = $_FILES['img']['type'];
        $destination = BASE_URL . "/front/images/articles//" . $imgName;

        if (str_contains($fileType, 'image') === false) {
            //Trouble in error viewing (if file not an image !!)
            array_push($errorMsg, "Uploaded file is not image!");
        } else {
            $result = move_uploaded_file($fileTmpName, $destination);
            if ($result) {
                $_POST['img'] = $imgName;
            } else {
                array_push($errorMsg, "Image uploading error!");
            }
        }
    } else {
        array_push($errorMsg, "Image receiving error!");
    }
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category']);
    $publish = isset($_POST['publish']) ? 1 : 0;

    if ($title === '' || $content === '' || $category === '') {
        array_push($errorMsg, "All fields must be filled!");
    } elseif (mb_strlen($title, 'UTF8') < 5) {
        array_push($errorMsg, "Article title must include at least 5 symbols!");
    } else {
        $article = [
            'id_user' => $_SESSION['id'],
            'title' => $title,
            'content' => $content,
            'img' => $_POST['img'],
            'status' => $publish,
            'id_category' => $category
        ];
        $article = insert('articles', $article);
        $article = selectOne('articles', ['id' => $id]);
        header('location: ' . BASE_URL . 'admin/articles/index.php');
    }
} else {
    $id = '';
    $title = '';
    $content = '';
    $publish = '';
    $category = '';
}

//Article edit
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $article = selectOne('articles', ['id'=> $_GET['id']]);

    $id = $article['id'];
    $title = $article['title'];
    $content = $article['content'];
    $category = $article['id_category'];
    $publish = $article['status'];


}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_article'])) {
    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category']);
    $publish = isset($_POST['publish']) ? 1 : 0;

    //Need function
    if (!empty($_FILES['img']['name'])) {
        $imgName = time() . "_" . $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileType = $_FILES['img']['type'];
        $destination = BASE_URL . "/front/images/articles//" . $imgName;

        if (str_contains($fileType, 'image') === false) {
            //Trouble in error viewing (if file not an image !!)
            array_push($errorMsg, "Uploaded file is not image!");
        } else {
            $result = move_uploaded_file($fileTmpName, $destination);
            if ($result) {
                $_POST['img'] = $imgName;
            } else {
                array_push($errorMsg, "Image uploading error!");
            }
        }
    } else {
        array_push($errorMsg, "Image receiving error!");
    }


    if ($title === '' || $content === '' || $category === '') {
        array_push($errorMsg, "All fields must be filled!");
    } elseif (mb_strlen($title, 'UTF8') < 5) {
        array_push($errorMsg, "Article title must include at least 5 symbols!");
    } else {
        $article = [
            'id_user' => $_SESSION['id'],
            'title' => $title,
            'content' => $content,
            'img' => $_POST['img'],
            'status' => $publish,
            'id_category' => $category
        ];
        $article = update('articles', $id, $article);
        header('location: ' . BASE_URL . 'admin/articles/index.php');
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pub_id'])) {
    $id = $_GET['pub_id'];
    $publish = $_GET['publish'];

    $articleId = update('articles', $id, ['status'=> $publish]);
    header('location: ' . BASE_URL . 'admin/articles/index.php');
    exit();
}

//Article del
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    delete('articles', $id);
    header('location: ' . BASE_URL . 'admin/articles/index.php');
}

?>



