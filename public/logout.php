<?php 

require_once("../src/Session.php"); 
$session->logout();
header("Location: login.php");

?>