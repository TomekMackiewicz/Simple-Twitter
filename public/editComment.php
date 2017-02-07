<?php
require_once('../src/Session.php');
require_once('../src/Comment.php');

$message = "";

$comment = Comment::loadCommentById($conn, $_GET['id']);
$location = $_GET['from'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST)) {
		$comment->setUserID($comment->getUserID());
		$comment->setText($_POST['editComment']);
		$comment->setCreationDate($comment->getCreationDate());
		$comment->saveToDB($conn);
		$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Comment edited successfully.</div>';		
		header("Location: ".$location);
	} else {
		$message = '<div class="alert alert-danger" role="alert">Please fill in the form.</div>';
	}
}

require_once('templates/header.php');

?>

<div class="container">
	<div class="row">
  	<div class="col-md-12">
  		<h2>Edit Comment</h2>

  		<?php echo $message ?>
  		
			<form action="#" method="POST">
				<div class="form-group">
		    	<label for="editComment">Comment text</label>
		    	<textarea class="form-control" id="editComment" name="editComment" maxlength="200"><?php echo $comment->getText() ?></textarea>
		    </div>				  
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
  	</div>
  </div>
</div>

<?php require_once('templates/footer.php'); ?>