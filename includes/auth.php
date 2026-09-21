<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function userLogin()
{
    return isset($_SESSION['user_login']) && $_SESSION['user_login'] === true;
}

function adminLogin()
{
    return isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true;
}

function wajibUser()
{
    if (!userLogin()) {
        header("Location: login.php");
        exit;
    }
}

function wajibAdmin()
{
    if (!adminLogin()) {
        header("Location: login.php");
        exit;
    }
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;

}
?>