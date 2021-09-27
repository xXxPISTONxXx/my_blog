<?php
    include(dirname(__FILE__)."/../database/db.php");

    $isSubmit = false;
    $errorMsg = [];

    function userAuth($user) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['admin'] = $user['admin'];
        $_SESSION['username'] = $user['username'];


        if ($_SESSION['id']) {
            header('location: ' . BASE_URL . 'index.php');
        }
    }

    $users = selectAll('users');
    //REG form
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-reg'])) {
        $admin = 0;
        $email = trim($_POST['email']);
        $login = trim($_POST['login']);
        $username = trim($_POST['username']);
        $passwordF = trim($_POST['pass-first']);
        $passwordS = trim($_POST['pass-second']);

        if ($email === '' || $login === '' || $username === '' || $passwordF === '') {
            array_push($errorMsg, "All fields must be filled!");
        } elseif (mb_strlen($login, 'UTF8') < 2) {
            array_push($errorMsg, "Login must include at least 2 symbols!");
        } elseif (mb_strlen($username, 'UTF8') < 5) {
            array_push($errorMsg, "Username must include at least 5 symbols!");
        } elseif ($passwordF !== $passwordS) {
            array_push($errorMsg, "Passwords are not the same!");
        } elseif (mb_strlen($passwordF, 'UTF8') < 7) {
            array_push($errorMsg, "Password must include at least 7 symbols!");
        } else {
            $existenceMail = selectOne('users', ['email' => $email]);
            if ($existenceMail != false && $existenceMail['email'] === $email) {
                $errorMsg = "This mail is already used!";
            } elseif ($existenceLogin = selectOne('users', ['login' => $login])) {
                if ($existenceLogin != false && $existenceLogin['login'] === $login) {
                    $errorMsg = "This login is already used!";
                }
            }
            else {
                $pass = password_hash($passwordF, PASSWORD_DEFAULT);
                $post = [
                    'admin' => $admin,
                    'email' => $email,
                    'login' => $login,
                    'username' => $username,
                    'password' => $pass
                ];

                $id = insert('users', $post);
                $user = selectOne('users', ['id' => $id]);

                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['admin'] = $user['admin'];

                if ($_SESSION['admin']) {
                    header('location: ' . BASE_URL . 'admin/admin.php');
                } else {
                    header('location: ' . BASE_URL);
                }
            }
        }
    } else {

        $email = '';
        $login = '';
        $username = '';
    }

    //AUTH form
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-log'])) {
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);

        if ($login === '' || $password === '') {
            array_push($errorMsg, "All fields must be filled!");
    } else {
            $existenceLogin = selectOne('users', ['login' => $login]);
            if ($existenceLogin && password_verify($password, $existenceLogin['password'])) {
                userAuth($existenceLogin);
            } else {
                array_push($errorMsg, "Incorrect login or password!");
            }
        }
    } else {
        $login = '';
    }

    //Add user in adm pnl
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-user'])) {

    $admin = 0;
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $username = trim($_POST['username']);
    $passwordF = trim($_POST['pass-first']);
    $passwordS = trim($_POST['pass-second']);

    if ($email === '' || $login === '' || $username === '' || $passwordF === '') {
        array_push($errorMsg, "All fields must be filled!");
    } elseif (mb_strlen($login, 'UTF8') < 2) {
        array_push($errorMsg, "Login must include at least 2 symbols!");
    } elseif (mb_strlen($username, 'UTF8') < 5) {
        array_push($errorMsg, "Username must include at least 5 symbols!");
    } elseif ($passwordF !== $passwordS) {
        array_push($errorMsg, "Passwords are not the same!");
    } elseif (mb_strlen($passwordF, 'UTF8') < 7) {
        array_push($errorMsg, "Password must include at least 7 symbols!");
    } else {
        $existenceMail = selectOne('users', ['email' => $email]);
        if ($existenceMail != false && $existenceMail['email'] === $email) {
            array_push($errorMsg, "This mail is already used!");
        } elseif ($existenceLogin = selectOne('users', ['login' => $login])) {
            if ($existenceLogin != false && $existenceLogin['login'] === $login) {
                array_push($errorMsg, "This login is already used!");
            }
        }
        else {
            $pass = password_hash($passwordF, PASSWORD_DEFAULT);
            if (isset($_POST['admin'])) $admin = 1;
            $user = [
                'admin' => $admin,
                'email' => $email,
                'login' => $login,
                'username' => $username,
                'password' => $pass
            ];

            $id = insert('users', $user);
            $user = selectOne('users', ['id' => $id]);

            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin'] = $user['admin'];

            if ($_SESSION['admin']) {
                header('location: ' . BASE_URL . 'admin/admin.php');
            } else {
                header('location: ' . BASE_URL);
            }
        }
    }
} else {

    $email = '';
    $login = '';
    $username = '';
}
//Del users
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    delete('users', $id);
    header('location: ' . BASE_URL . 'admin/users/index.php');
}

//Edit user
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit_id'])) {
    $user = selectOne('users', ['id'=> $_GET['edit_id']]);

    $id = $user['id'];
    $admin = $user['admin'];
    $login = $user['login'];
    $email = $user['email'];
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
        $destination = ROOT_PATH . "/front/images/articles//" . $imgName;

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
?>