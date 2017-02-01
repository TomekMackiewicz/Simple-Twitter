<?php
require_once('../src/Session.php');
require_once('../src/Tweet.php');
require_once('../src/Comment.php');
require_once('../src/Message.php');
require_once('../src/User.php');

$userID = $_GET['id'];

$user = User::loadUserById($conn, $userID);

$tweets = "";
if(!empty(Tweet::loadAllTweetsByUserId($conn, $userID))) {
	$userTweets = Tweet::loadAllTweetsByUserId($conn, $userID);
	foreach ($userTweets as $tweet) {															  
	  $tweets .= "<tr>";
	  $tweets .= "<td>" . $tweet->getID() . "</td>";
	  $tweets .= "<td>" . $tweet->getText() . "</td>";
	  $tweets .= "<td>" . $tweet->getCreationDate() . "</td>";
	  $tweets .= '<td class="fit">';
	  $tweets .= '<a class="btn btn-default btn-xs" href="details.php?id='.$tweet->getID().'">Details</a> ';
	  $tweets .= "</td>";
	  $tweets .= "</tr>";
	}
} else {
	$tweets .= "<tr><td>No tweets yet.</td></tr>";
}

$comments = "";
if(!empty(Comment::loadAllCommentsByUserId($conn, $userID))) {
	$userComments = Comment::loadAllCommentsByUserId($conn, $userID);
	foreach ($userComments as $comment) {															  
	  $comments .= "<tr>";
	  $comments .= "<td>" . $comment->getUserID() . "</td>";
	  $comments .= "<td>" . $comment->getPostID() . "</td>";
	  $comments .= "<td>" . $comment->getText() . "</td>";
	  $comments .= "<td>" . $comment->getCreationDate() . "</td>";
	  $comments .= "</tr>";
	}
} else {
	$comments .= "<tr><td>No comments yet.</td></tr>";
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
  	<div class="col-md-12">
  		<h1>Profile of <?php echo $user->getUsername() ?></h1>
  		<h2>Tweets</h2>

  		<?php echo $message ?>
  		
			<table class="table">
				<tr>
					<th>ID</th>
					<th>Text</th>
					<th>Date</th>
					<th>Actions</th>
				</tr>

  			<?php echo $tweets ?>

			</table>
  		<h2>Comments</h2>
			<table class="table">
				<tr>
					<th>User ID</th>
					<th>Post ID</th>
					<th>Text</th>
					<th>Date</th>
				</tr>

  			<?php echo $comments ?>

			</table>						
  	</div>		    	
  </div>
</div>

<?php require_once('templates/footer.php'); ?>