<?php
require_once('../src/Session.php');
require_once('../src/Comment.php');

Comment::deleteComment($conn,$_GET['id']);

header("Location: ".$_GET['from']);

$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Comment deleted successfully.</div>';

?>

