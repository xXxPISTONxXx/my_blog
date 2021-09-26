
<?php

$conn = mysqli_connect("localhost", "root", "root", "my_blog");
//$result = $conn->query("SELECT * FROM `articles`");
//$result_cookie = $conn->query("SELECT * FROM `users`");
//$user = mysqli_fetch_assoc($result_cookie);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
          crossorigin="anonymous">
    <link rel="stylesheet" href="front/css/style.css">
    <title>My first blog</title>
</head>
<body>
<?php include("include/header.php"); ?>

<?php
$article = $conn->query("SELECT * FROM `articles` WHERE `id` = " . (int) $_GET['id']);
if (mysqli_num_rows($article) <= 0)
{
?>
<div class="container">
    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
            <!-- <strong class="d-inline-block mb-2 text-primary">World</strong> -->
            <h3 class="mb-0">Ooops... Something is going wrong!</h3>
            <p class="card-text mb-auto">Article not found!</p>

            <?php } else
            {
            $new_post = mysqli_fetch_assoc($article);
            ?>
            <div class="container">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <!-- <strong class="d-inline-block mb-2 text-primary">World</strong> -->
                        <h3 class="mb-0"><?php
                            echo $new_post['title'];?></h3>
                        <div class="mb-1 text-muted">
                            <?php
                            echo $mysqldate = date("j M y",strtotime($new_post['pubdate']));
                            ?> </div>
                        <p class="card-text mb-auto"><?php echo $new_post['text'];?></p>
                        <div class="mt-1 text-muted">
                            <a>666 views</a>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <?php
                if(isset($_COOKIE['logged'])):
                    ?>
                    <div class="container">
                        <button class="btn btn-outline-primary" type="submit">Edit</button>
                        <button class="btn btn-outline-danger" type="submit">Delete</button>
                    </div>
                <?php endif;?>

                <!-- Comments -->
                <div class="container">
                    <h4>Comments</h4>
                </div>

                <div class="container">
                    <h5>Type your comment here...</h5>
                    <form action="<?=BASE_URL . "article.php?id=$page;"?> method="post">
                    <input type="hidden" name="page" value="<?=$page; ?>">
                    <div class="mb-3">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary" type="submit">Post your comment</button>
                    </div>
                    </form>
                </div>

                <?php include("include/footer.php"); ?>
</body>
</html>

