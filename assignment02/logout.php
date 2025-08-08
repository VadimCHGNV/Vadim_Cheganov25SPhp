<?php
// exit session and redirect

require_once 'config.php';

session_unset();
session_destroy();

header('location: index.php');
exit;
