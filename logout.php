<?php
    session_start();
    $_SESSION['username'] = NULL;
    $_SESSION['user'] = NULL;
    $_SESSION['hostid'] = NULL;
    header('Location: expired.php');
?>