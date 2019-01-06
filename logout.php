<?php
    session_start();
    // $_SESSION['username'] = NULL;
    // $_SESSION['user'] = NULL;
    // $_SESSION['hostid'] = NULL;
    unset($_SESSION["username"]);
    unset($_SESSION["user"]);
    unset($_SESSION["hostid"]);
    unset($_SESSION["permission_view"]);
    unset($_SESSION["permission_control"]);
    unset($_SESSION["host_name"]);
    
    header('Location: expired.php');
?>