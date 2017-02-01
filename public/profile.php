<?php
require_once('../src/Session.php');
require_once('../src/Tweet.php');
require_once('../src/Comment.php');
require_once('../src/Message.php');
require_once('../src/User.php');

$messagesReceived = Message::loadAllMessagesByReceiver($conn, $_SESSION['id']);
$messagesSent = Message::loadAllMessagesBySender($conn, $_SESSION['id']);

if(is_array($messagesReceived)) {
	$countR = sizeof($messagesReceived);
} else {
	$countR = 0;
}

if(is_array($messagesReceived)) {
	$countS = sizeof($messagesReceived);
} else {
	$countS = 0;
}

$tweets = "";
if(!empty(Tweet::loadAllTweetsByUserId($conn, $_SESSION['id']))) {
	$userTweets = Tweet::loadAllTweetsByUserId($conn, $_SESSION['id']);
	foreach ($userTweets as $tweet) {															  
	  $tweets .= "<tr>";
	  $tweets .= "<td>" . $tweet->getID() . "</td>";
	  $tweets .= "<td>" . $tweet->getText() . "</td>";
	  $tweets .= "<td>" . $tweet->getCreationDate() . "</td>";
	  $tweets .= '<td class="fit">';
	  $tweets .= '<a class="btn btn-default btn-xs" href="details.php?id='.$tweet->getID().'">Details</a> ';
	  $tweets .= '<a href="editTweet.php?id='.$tweet->getID().'&from=profile.php" class="btn btn-primary btn-xs">Edit</a> ';
	  $tweets .= '<a href="deleteTweet.php?id='.$tweet->getID().'&from=profile.php" class="btn btn-danger btn-xs">Delete</a>';
	  $tweets .= "</td>";
	  $tweets .= "</tr>";
	}
} else {
		$tweets .= "<tr><td>No tweets yet.</td></tr>";
}

$comments = "";
if(!empty(Comment::loadAllCommentsByUserId($conn, $_SESSION['id']))) {
	$userComments = Comment::loadAllCommentsByUserId($conn, $_SESSION['id']);
	foreach ($userComments as $comment) {															  
	  $comments .= "<tr>";
	  $comments .= "<td>" . $comment->getUserID() . "</td>";
	  $comments .= "<td>" . $comment->getPostID() . "</td>";
	  $comments .= "<td>" . $comment->getText() . "</td>";
	  $comments .= "<td>" . $comment->getCreationDate() . "</td>";
	  $comments .= '<td class="fit">';
		$comments .= '<a href="editComment.php?id='.$comment->getID().'&from=profile.php" class="btn btn-primary btn-xs">Edit</a> ';
		$comments .= '<a href="deleteComment.php?id='.$comment->getID().'&from=profile.php" class="btn btn-danger btn-xs">Delete</a>';
	  $comments .= "</td>";
	  $comments .= "</tr>";
	}
} else {
	$comments .= "<tr><td>No comments yet.</td></tr>";
}

$edit  = "";
$edit .= '<a href="changeUsername.php?id='.$_SESSION['id'].'&from=profile.php">Change username</a><br>';
$edit .= '<a href="resetPassword.php?id='.$_SESSION['id'].'&from=profile.php"">Reset password</a><br>';
$edit .= '<a href="deleteUser.php?id='.$_SESSION['id'].'">Delete account</a>';

$inbox = "";
if($countR > 0) {
	foreach($messagesReceived as $message) {
		$sender = User::loadUserById($conn, $message->getSenderID());
		$inbox .= '<small> From <a href="userProfile.php?id='.$sender->getID().'">'.$sender->getUsername().'</a>, sent: '.$message->getCreationDate().'</small>';
		if($message->getViewed() == 1) {
			$inbox .= "<p>".$message->getText()."</p>";	
		} else {
			$inbox .= "<p><strong>".$message->getText()."</strong></p>";
			$inbox .= '<a href="markAsRead.php?id='.$message->getID().'&from=profile.php" class="btn btn-default btn-xs">Mark as read</a> ';			    				
		}
		$inbox .= '<a href="respond.php?receiver='.$message->getSenderID().'&from=profile.php" class="btn btn-primary btn-xs">Respond</a> ';
		$inbox .= '<a href="deleteMessage.php?id='.$message->getID().'&from=profile.php" class="btn btn-danger btn-xs">Delete</a>';
		$inbox .= "<hr>";		
	}		    			
} else {
	$inbox .= "<p>No messages.</p>";
}

$sent = "";
if($countS > 0) {
	foreach($messagesSent as $message) {
		$sender = User::loadUserById($conn, $message->getReceiverID());
		$sent .= '<small> To <a href="userProfile.php?id='.$sender->getID().'">'.$sender->getUsername().'</a>, sent: '.$message->getCreationDate().'</small>';
		$sent .= "<p>".$message->getText()."</p>";
		$sent .= '<a href="deleteMessage.php?id='.$message->getID().'&from=profile.php" class="btn btn-danger btn-xs">Delete</a>';
		$sent .= "<hr>";			    			
	}		    			
} else {
	$sent .= "<p>No messages.</p>";
}

if(!empty($_SESSION['msg'])) {
	$message = $_SESSION['msg'];
} else {
	$message = "";
}

include('templates/header.php');

?>

<div class="container">
	<div class="row">
  	<div class="col-md-9">

  		<?php echo $message ?>
  		<?php unset($_SESSION['msg']) ?>

  		<h2>Your tweets</h2>
			<table class="table">
				<tr>
					<th>ID</th>
					<th>Text</th>
					<th>Date</th>
					<th>Actions</th>
				</tr>

  			<?php echo $tweets ?>

			</table>
  		<h2>Your comments</h2>
			<table class="table">
				<tr>
					<th>User ID</th>
					<th>Post ID</th>
					<th>Text</th>
					<th>Date</th>
					<th>Actions</th>
				</tr>

  			<?php echo $comments ?>

			</table>						
  	</div>
  	<div class="col-md-3">
  		<h2>Edit profile</h2>
			
  		<?php echo $edit ?>

  		<h2>Messages</h2>
  		<a href="newMessage.php?from=profile.php" class="btn btn-default">New message</a>			    		
  		<h3>Inbox <span class="badge"><?php echo $countR ?></span></h3>

  		<?php echo $inbox ?>

  		<h3>Sent</h3>

  		<?php echo $sent ?>

  	</div>		    	
  </div>
</div>

<?php require_once('templates/footer.php'); ?>