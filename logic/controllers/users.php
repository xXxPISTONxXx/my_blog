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
                array_push($errorMsg,"This mail is already used!");
            } elseif ($existenceLogin = selectOne('users', ['login' => $login])) {
                if ($existenceLogin != false && $existenceLogin['login'] === $login) {
                    array_push($errorMsg,"This login is already used!");
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
            header('location: ' . BASE_URL . 'admin/users/index.php');

            /*$_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin'] = $user['admin'];

            if ($_SESSION['admin']) {
                header('location: ' . BASE_URL . 'admin/users/index.php');
            } else {
                header('location: ' . BASE_URL);
            }*/
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
    $username = $user['username'];
    $login = $user['login'];
    $email = $user['email'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-user'])) {
    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $passwordF = trim($_POST['pass-first']);
    $passwordS = trim($_POST['pass-second']);
    $admin = isset($_POST['admin']) ? 1 : 0;


    if ($username === '') {
        array_push($errorMsg, "Username form must be filled!");
    } elseif (mb_strlen($username, 'UTF8') < 5) {
        array_push($errorMsg, "Username must include at least 5 symbols!");
    } elseif ($passwordF !== $passwordS) {
        array_push($errorMsg, "Passwords are not the same!");
    } else {


        $user = [
            'admin' => $admin,
            'username' => $username,
            /*'login' => $login,
            'email' => $email,*/
            'password' => $pass
        ];
        $user = update('users', $id, $user);
        header('location: ' . BASE_URL . 'admin/users/index.php');
    }
} else {
    $username = '';
    $email = '';
    $login = '';
}
/*if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pub_id'])) {
    $id = $_GET['pub_id'];
    $publish = $_GET['publish'];

    $articleId = update('articles', $id, ['status'=> $publish]);
    header('location: ' . BASE_URL . 'admin/articles/index.php');
    exit();
}*/
?>