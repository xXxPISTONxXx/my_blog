<?php
include("../../path.php");
include("../../logic/controllers/users.php");
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
    <title>#ЯРОДИЛСЯ ОДМЭН</title>
</head>
<body>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
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
            <h3>CREATE NEW USER</h3>
            <div class="row add-article">
                <div class="mb-3 col-12 col-md-4 err">
                    <!--Array with errors-->
                    <?php include("../../logic/helpers/error_info.php"); ?>
                </div>
                <form action="edit.php" method="post">
                    <div class="col mb-4">
                        <input type="hidden" name="id" value="<?=$user['id'];?>">
                        <label for="formGroupExampleInput" class="form-label">Username</label>
                        <input type="text" name="username" value="<?=$user['username'];?>" class="form-control" id="formGroupExampleInput" placeholder="">
                    </div>
                    <div class="col mb-4">
                        <label for="exampleInputEmail1" class="form-label">E-mail address</label>
                        <input type="email" name="email" value="<?=$user['email'];?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
                        <div id="emailHelp" class="form-text"></div>
                    </div>
                    <div class="col mb-4">
                        <label for="formGroupExampleInput" class="form-label">Login</label>
                        <input type="text" name="login" value="<?=$user['login'];?>" class="form-control" id="formGroupExampleInput" placeholder="" disabled>
                    </div>
                    <div class="col mb-4">
                        <label for="exampleInputPassword1" class="form-label">Reset password</label>
                        <input type="password" name="pass-first" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="col mb-4">
                        <label for="exampleInputPassword1" class="form-label">Confirm password</label>
                        <input type="password" name="pass-second" class="form-control" id="exampleInputPassword2">
                    </div>
                    <div class="col col-6">
                        <label class="form-check-label" for="flexCheckChecked">Admin?</label>
                        <input class="form-check-input" value="1" type="checkbox" name="admin" id="flexCheckChecked">
                    </div>
                    <div class="col col-6 mt-4">
                        <button name="update-user" class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Main block ending-->

<?php include("../../include/footer.php"); ?>
</body>
</html>
