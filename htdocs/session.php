<?php
session_start();

function check_login()
{
    if (isset($_COOKIE["user_id"])) {
        $user_id = $_COOKIE['user_id'];
        $username = $_COOKIE['username'];

        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
    }

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }
}

function redirect_if_logged_in()
{
    if (isset($_SESSION["user_id"])) {
        header("Location: index.php");
        exit();
    }
}
