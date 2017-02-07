<?php
require_once('../src/Session.php');
require_once('../src/Message.php');

$msg = "";

$message = new Message();
$location = $_GET['from'];
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST['respond'])) {
		$message->setSenderID($_SESSION['id']);
		$message->setReceiverID($_GET['receiver']);
		$message->setText($_POST['respond']);
		$message->setViewed(0);
		$message->setCreationDate();
		$message->saveToDB($conn);
		$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Message sent successfully.</div>';		
		header("Location: ".$location);
	} else {
		$msg = '<div class="alert alert-danger" role="alert">Please fill in the form.</div>';
	}
}

require_once('templates/header.php');

?>

<div class="container">
	<div class="row">
  	<div class="col-md-12">
  		<h2>Answer</h2>

  		<?php echo $msg ?>

			<form action="#" method="POST">
				<div class="form-group">
		    	<label for="respond">Your answer</label>
		    	<textarea class="form-control" id="respond" name="respond" maxlength="200"></textarea>
		    </div>				  
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
  	</div>
  </div>
</div>

<?php require_once('templates/footer.php'); ?>