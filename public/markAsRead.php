<?php

require_once('../src/Message.php');

$message = Message::loadMessageById($conn,$_GET['id']);
$location = $_GET['from'];
$message->setViewed(1);
$message->markAsRead($conn);		
header("Location: ".$location);

?>