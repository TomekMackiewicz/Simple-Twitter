<?php
require_once('../src/Session.php');
require_once('../src/Config.php');
require_once('../src/User.php');

if($session->is_logged_in()) {
	header("Location: index.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST)) {
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$found_user = User::authenticateUser($conn, $email, $password);
		if($found_user == true) {
			$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Welcome! :)</div>';
			$session->login($found_user);
			header("Location: index.php");		
		} else {
			$_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Username/password combination incorrect.</div>';
		}
	} else {
		$email = '';
		$password = '';
		$_SESSION['msg'] = '';
	}
}

if(!empty($_SESSION['msg'])) {
	$message = $_SESSION['msg'];
} else {
	$message = "";
}

require_once('templates/header.php');

?>

	<div class="container">
		<div class="row">
	  	<div class="col-md-4"></div>
	  	<div class="col-md-4">
	  		<h2>Log in</h2>

	  		<?php echo $message ?>
	  		
				<form action="#" method="POST">
				  <div class="form-group">
				    <label for="InputEmail">your Email address</label>
				    <input type="email" class="form-control" id="InputEmail" name="email">
				  </div>
				  <div class="form-group">
				    <label for="InputPassword">Your Password</label>
				    <input type="password" class="form-control" id="InputPassword" name="password">
				  </div>
				  <button type="submit" class="btn btn-default">Submit</button>
				</form>
				<h4>No account yet? <a href="register.php">Register.</a></h4>
	  	</div>
	  	<div class="col-md-4"></div>
	  </div>
	</div>

<?php require_once('templates/footer.php'); ?>