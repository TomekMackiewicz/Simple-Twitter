<?php
require_once('../src/Session.php');
require_once('../src/Tweet.php');

Tweet::deleteTweet($conn,$_GET['id']);

header("Location: ".$_GET['from']);

$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Tweet deleted successfully.</div>';

?>