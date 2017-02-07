<?php
require_once('../src/Session.php');
require_once('../src/User.php');

$message = "";

if($_GET['id'] == $_SESSION['id']) {
	$user = User::loadUserById($conn, $_GET['id']);
	$location = $_GET['from'];
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
	 	if(!empty($_POST['resetPassword'])) {
	 		$user->setEmail($user->getEmail());
			$user->setUsername($user->getUsername());
			$user->setPassword($_POST['resetPassword']);
			$user->saveToDB($conn);
			$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Password changed successfully.</div>';		
			header("Location: ".$location);
	 	} else {
	 		$message = '<div class="alert alert-danger" role="alert">Please fill in the form.</div>';
	 	}
	}		
} else {
	$message = '<div class="alert alert-danger" role="alert">You can\'t modify other user\'s data.</div>';
}

require_once('templates/header.php');

?>

<div class="container">
	<div class="row">
  	<div class="col-md-12">
  		<h2>New password</h2>

  		<?php echo $message ?>

			<form action="#" method="POST">
				<div class="form-group">
		    	<label for="resetPassword">Password</label>
		    	<input type="text" class="form-control" id="resetPassword" name="resetPassword">
		    </div>				  
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
  	</div>
  </div>
</div>

<?php require_once('templates/footer.php'); ?>