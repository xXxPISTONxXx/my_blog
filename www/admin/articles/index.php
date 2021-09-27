<?php
include("../../path.php");
include("../../logic/controllers/articles.php");
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="../../front/css/admin.css" rel="stylesheet">

    <!-- My fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500;1,600&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
          integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title>My blog</title>
</head>
<body>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
-->


<?php include("../../include/header_admin.php"); ?>


<!--Main block-->
<div class="container">
    <div class="row">
        <?php include("../../include/sidebar_admin.php"); ?>
        <div class="articles col-10">
            <h3>ARTICLES CONTROL</h3>
            <div class="button row">
                <a href="<?=BASE_URL . 'admin/articles/create.php';?>" class="btn btn-primary">Add</a>
            </div>
            <div class="row title-table">
                <div class="col-1">
                    ID
                </div>
                <div class="col-3">
                    Title
                </div>
                <div class="col-2">
                    Author
                </div>
                <div class="col-6">
                    Manage
                </div>
            </div>
            <?php foreach ($articlesAdm as $key => $article): ?>
            <div class="row article">
                <div class="col-1">
                    <?=$key + 1; ?>
                </div>
                <div class="col-3">
                    <?=$article['title']; ?>
                </div>
                <div class="col-2">
                    <?=$article['username']; ?>
                </div>
                <div class="edit col-2">
                    <a href="edit.php?id=<?=$article['id'] ;?>">Edit</a>
                </div>
                <div class="delete col-2">
                    <a href="edit.php?delete_id=<?=$article['id'] ;?>">Delete</a>
                </div>
                <?php if ($article['status']): ?>
                    <div class="status col-2">
                        <a href="edit.php?publish=0&pub_id=<?=$article['id'] ;?>">Archive</a>
                    </div>
                <?php else: ?>
                    <div class="status col-2">
                        <a href="edit.php?publish=1&pub_id=<?=$article['id'] ;?>">Publish</a>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!--Main block ending-->

<?php include("../../include/footer.php"); ?>
</body>
</html>
