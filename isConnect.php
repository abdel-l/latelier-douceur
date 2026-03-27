<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['LOGGED_USER'])) {
    echo('Il faut être authentifié pour cette action.');
    exit;
}