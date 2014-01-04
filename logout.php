<?php
//fertig
session_start();
session_destroy();
unset($_COOKIE['rememberMe']);
setcookie('rememberMe', null, -1, '/');
header("location:index.php");
exit();
?>
