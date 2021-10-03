<?php
include_once( SITE_ROOT . "/logic/database/db.php");
//logic
$commentsForAdm = selectAll('comments');
$page = $_GET['article'];
$comment = '';
$errorMsg = [];
$status = 0;
$comments = [];

//Comment create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['goComment'])) {

    $comment = trim($_POST['comment']);


    if ($comment === '') {
        array_push($errorMsg, "Please, type something :(");
    } else {
        $status = 1;
        $comment = [
            'status' => $status,
            'page' => $page,
            'username' => $_SESSION['username'],
            'comment' => $comment
        ];
        $comment = insert('comments', $comment);
        $comments = selectAll('comments', ['page' => $page, 'status' => 1]);
    }
} else {
    $comment = '';
    $comments = selectAll('comments', ['page' => $page, 'status' => 1]);
}
//Comment del
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    delete('comments', $id);
    header('location: ' . BASE_URL . 'admin/comments/index.php');
}

//Status
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pub_id'])) {
    $id = $_GET['pub_id'];
    $publish = $_GET['publish'];

    $articleId = update('comments', $id, ['status' => $publish]);
    header('location: ' . BASE_URL . 'admin/comments/index.php');
    exit();
}
//Comment edit
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $oneComment = selectOne('comments', ['id'=> $_GET['id']]);

    $id = $oneComment['id'];
    $username = $oneComment['username'];
    $text1 = $oneComment['comment'];
    $pub = $oneComment['status'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_comment'])) {
    $id = $_POST['id'];
    $text = trim($_POST['content']);
    $publish = isset($_POST['publish']) ? 1 : 0;

    if ($text === '') {
        array_push($errorMsg, "Please, type something :(");
    } else {
        $com = [
            'comment' => $text,
            'status' => $publish
        ];
        $com = update('comments', $id, $com);
        header('location: ' . BASE_URL . 'admin/comments/index.php');
    }
}