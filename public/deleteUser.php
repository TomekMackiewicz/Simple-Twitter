<?php
require_once('../src/Session.php');
require_once('../src/User.php');

$session->logout();
 
User::deleteUser($conn,$_GET['id']);

$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Goodbye :)</div>';

header("Location: login.php");

?>