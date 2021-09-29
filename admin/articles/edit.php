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
<!--Visual txt editor-->
<script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>
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
            <h3>EDIT ARTICLE</h3>
            <div class="mb-3 col-12 col-md-4 err">
                <!--Array with errors-->
                <?php include("../../logic/helpers/error_info.php"); ?>
            </div>
            <div class="row add-article">
                <form action="edit.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$id; ?>">
                    <div class="col mb-4">
                        <label for="article" class="form-label">Title of article</label>
                        <input value="<?=$article['title']; ?>" name="title" type="text" class="form-control" placeholder="e.g. Hello, world!..." aria-label="Article title">
                    </div>
                    <div class="col mb-4">
                        <label for="editor" class="form-label">Text of article</label>
                        <textarea value="" name="content" id="editor" class="form-control" placeholder="e.g. My name is John and this is my new article!..."
                                  rows="6"><?=$article['content']; ?></textarea>
                    </div>
                    <div class="input-group mb-4">
                        <input name="img" type="file" class="form-control" id="inputGroupFile02">
                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                    </div>
                    <select name="category" class="form-select mb-4" aria-label="Default select example">
                        <?php foreach ($categories as $key => $category): ?>
                            <option value="<?=$category['id'];?>">
                                <?=$category['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="col col-6">
                        <?php if (empty($publish) && $publish == 0): ?>
                        <input class="form-check-input" type="checkbox" name="publish" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">Publish</label>
                        <?php else: ?>
                        <input class="form-check-input" type="checkbox" name="publish" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">Publish</label>
                        <?php endif; ?>
                    </div>
                    <div class="col col-6">
                        <button name="edit_article" class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Main block ending-->
<?php include("../../include/footer.php"); ?>
<script src="../../front/js/scripts.js"></script>
</body>
</html>
