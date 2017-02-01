<?php
require_once('../src/Session.php');
require_once('../src/Tweet.php');

$message = "";

$tweet = Tweet::loadTweetById($conn, $_GET['id']);
$location = $_GET['from'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST['editTweet'])) {
		$tweet->setUserID($tweet->getUserID());
		$tweet->setText($_POST['editTweet']);
		$tweet->setCreationDate($tweet->getCreationDate());
		$tweet->saveToDB($conn);
		$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Tweet edited successfully.</div>';		
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
  		<h2>Edit Tweet</h2>

  		<?php echo $message ?>

			<form action="#" method="POST">
				<div class="form-group">
		    	<label for="editTweet">Tweet text</label>
		    	<textarea class="form-control" id="editTweet" name="editTweet" maxlength="200"><?php echo $tweet->getText() ?></textarea>	
		    </div>			  
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
  	</div>
  </div>
</div>

<?php require_once('templates/footer.php'); ?>