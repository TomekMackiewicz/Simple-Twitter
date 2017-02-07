<?php
require_once('../src/Session.php');
require_once('../src/Tweet.php');
require_once('../src/Comment.php');
require_once('../src/User.php');

$tweet = "";
$comm = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST)) {
		$comment = new Comment;
		$comment->setUserID($_SESSION['id']);
		$comment->setPostID($_GET['id']);
		$comment->setCreationDate();
		$comment->setText($_POST['comment']);
		$comment->saveToDB($conn);
		$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Comment added successfully.</div>';
	}
}

if(!empty($_SESSION['msg'])) {
	$message = $_SESSION['msg'];
} else {
	$message = "";
}

$tweetDetails = Tweet::loadTweetById($conn, $_GET['id']);
$comments = Comment::loadAllCommentsByPostId($conn, $_GET['id']);
$author = User::loadUserById($conn, $tweetDetails->getUserID());

if($_SESSION['id'] == $author->getID()) {
	$tweet .= '<p>'.$author->getUsername().'</p>';
} else {
	$tweet .= '<p><a href="userProfile.php?id='.$author->getID().'">'.$author->getUsername().'</a></p>';
}
$tweet .= "<small>".
	$tweetDetails->getCreationDate()." (user id: ".
	$tweetDetails->getUserID().", tweet id: ".
	$tweetDetails->getID().")</small>";
$tweet .= "<blockquote>";
$tweet .= "<p>".$tweetDetails->getText()."</p>";
$tweet .= "</blockquote>";
if($tweetDetails->getUserID() == $_SESSION['id']) {
	$tweet .= '<a href="editTweet.php?id='.$tweetDetails->getID().'&from=details.php?id='.$tweetDetails->getID().'" class="btn btn-primary btn-xs">Edit</a> ';
	$tweet .= '<a href="deleteTweet.php?id='.$tweetDetails->getID().'&from=index.php" class="btn btn-danger btn-xs">Delete</a>';
}									
$tweet .= "<hr>";
$tweet .= "<h4>Comments</h4><br>";

if(!empty($comments)) {
	foreach($comments as $comment) {
		$author = User::loadUserById($conn, $comment->getUserID());

		if($_SESSION['id'] == $author->getID()) {
			$comm .= '<small>'.$author->getUsername().' wrote:</small><br>';
		} else {
			$comm .= '<small><a href="userProfile.php?id='.$author->getID().'">'.$author->getUsername().'</a> wrote:</small><br>';
		}
		$comm .= "<p>".$comment->getText()."<p>";
		$comm .= "<small>".$comment->getCreationDate()."</small><br>";
		if($author->getID() == $_SESSION['id']) {
			$comm .= '<a href="editComment.php?id='.$comment->getID().'&from=details.php?id='.$_GET['id'].'" class="btn btn-primary btn-xs">Edit</a> ';
			$comm .= '<a href="deleteComment.php?id='.$comment->getID().'&from=details.php?id='.$_GET['id'].'" class="btn btn-danger btn-xs">Delete</a>';
		}										 
		$comm .= "<hr>";
	}									
} else {
	$comm .= "No comments yet.";
}

include('templates/header.php');

?>

<div class="container">
	<div class="row">
  	<div class="col-md-12">
  		<h2>Single Tweet</h2>

  		<?php echo $message ?>
  		<?php unset($_SESSION['msg']) ?>
  		
  		<hr>

			<?php echo $tweet ?>

			<?php echo $comm ?>

			<hr>
			<h4>Add new comment</h4>
			<form action="#" method="POST">
			  <div class="form-group">
			    <textarea class="form-control" id="comment" name="comment" maxlength="200"></textarea>
			  </div>
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
  	</div>
  </div>
</div>

<?php require_once('templates/footer.php'); ?>