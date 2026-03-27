<?php
session_start();
require_once(__DIR__ . '/functions.php');

// déconnexion complète
$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

session_destroy();

redirectToUrl('index.php');