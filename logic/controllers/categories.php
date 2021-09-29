<?php
include(dirname(__FILE__)."/../database/db.php");
$errorMsg = '';
$id = '';
$name = '';
$description = '';

//Categories listing
$categories = selectAll('categories');



//Category create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category-create'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if ($name === '' || $description === '') {
        $errorMsg = "All fields must be filled!";
    } elseif (mb_strlen($name, 'UTF8') < 2) {
        $errorMsg = "Category name must include at least 2 symbols!";
    } else {
        $existenceName = selectOne('categories', ['name' => $name]);
        if ($existenceName != false && $existenceName['name'] === $name) {
            $errorMsg = "This category name is already used!";
        }
        else {
            $category = [
                'name' => $name,
                'description' => $description
            ];
            $id = insert('categories', $category);
            $category = selectOne('categories', ['id' => $id]);
            header('location: ' . BASE_URL . 'admin/categories/index.php');
        }
    }
} else {

    $name = '';
    $description = '';
}

//Category edit
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $category = selectOne('categories', ['id'=> $id]);
    $id = $category['id'];
    $name = $category['name'];
    $description = $category['description'];

}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category-edit'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if ($name === '' || $description === '') {
        $errorMsg = "All fields must be filled!";
    } elseif (mb_strlen($name, 'UTF8') < 2) {
        $errorMsg = "Category name must include at least 2 symbols!";
    } else {
            $category = [
                'name' => $name,
                'description' => $description
            ];
            $id = $_POST['id'];
            $category_id = update('categories', $id, $category);
            header('location: ' . BASE_URL . 'admin/categories/index.php');
        }
}

//Category del
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    delete('categories', $id);
    header('location: ' . BASE_URL . 'admin/categories/index.php');


}

?>



