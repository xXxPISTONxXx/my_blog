<?php
    include(dirname(__FILE__)."/../database/db.php");
    include(dirname(__FILE__)."/../../path.php");

    $isSubmit = false;
    $errorMsg = '';

    function userAuth($user) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['admin'] = $user['admin'];
        $_SESSION['username'] = $user['username'];


        if ($_SESSION['id']) {
            header('location: ' . BASE_URL . 'index.php');
        }
    }
    //REG form
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-reg'])) {
        $admin = 0;
        $email = trim($_POST['email']);
        $login = trim($_POST['login']);
        $username = trim($_POST['username']);
        $passwordF = trim($_POST['pass-first']);
        $passwordS = trim($_POST['pass-second']);

        if ($email === '' || $login === '' || $username === '' || $passwordF === '') {
            $errorMsg = "All fields must be filled!";
        } elseif (mb_strlen($login, 'UTF8') < 2) {
            $errorMsg = "Login must include at least 2 symbols!";
        } elseif (mb_strlen($username, 'UTF8') < 5) {
            $errorMsg = "Username must include at least 5 symbols!";
        } elseif ($passwordF !== $passwordS) {
            $errorMsg = "Passwords are not the same!";
        } elseif (mb_strlen($passwordF, 'UTF8') < 7) {
            $errorMsg = "Password must include at least 7 symbols!";
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
            $errorMsg = "All fields must be filled!";
    } else {
            $existenceLogin = selectOne('users', ['login' => $login]);
            if ($existenceLogin && password_verify($password, $existenceLogin['password'])) {
                userAuth($existenceLogin);
            } else {
                $errorMsg = "Incorrect login or password!";
            }
        }
    } else {
        $login = '';
    }



?>