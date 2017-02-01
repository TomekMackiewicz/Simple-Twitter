<?php
require_once('../src/Session.php');
require_once('../src/Message.php');
require_once('../src/User.php');

$message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
 	if(!empty($_POST['message'])) {
		$message = new Message();
		$receiver = User::loadUserByEmail($conn, $_POST['to']);
		$location = $_GET['from'];
		$message->setSenderID($_SESSION['id']);
		$message->setReceiverID($receiver->getID());
		$message->setText($_POST['message']);
		$message->setViewed(0);
		$message->setCreationDate();
		$message->saveToDB($conn);
		$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Message sent.</div>';		
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
  		<h2>New message</h2>

  		<?php echo $message ?>

			<form action="#" method="POST">
				<div class="form-group">				
					<label for="to">To (email):</label>
					<input type="text" class="form-control" id="to" name="to">
				</div> 
				<div class="form-group">
		    	<label for="message">Message</label>
		    	<textarea class="form-control" id="message" name="message" maxlength="200"></textarea>
		    </div>				  
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
  	</div>
  </div>
</div>

<?php require_once('templates/footer.php'); ?>