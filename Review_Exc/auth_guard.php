<?php
// guard just to require user to be loggedin
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
