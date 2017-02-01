<?php
require_once('../src/Session.php');
require_once('../src/Message.php');

Message::deleteMessage($conn,$_GET['id']);

header("Location: ".$_GET['from']);

$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Message deleted successfully.</div>';

?>