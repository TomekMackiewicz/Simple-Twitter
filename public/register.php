<?php
require_once('../src/Session.php');
require_once('../src/Config.php');
require_once('../src/User.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST)) {
		$user = new User();
		$user->setUsername(trim($_POST['username']));
		$user->setEmail(trim($_POST['email']));
		$user->setPassword(trim($_POST['password']));
		$user->saveToDB($conn);
		$_SESSION['id'] = $conn->lastInsertId();;
		$_SESSION['username'] = trim($_POST['username']);
		$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Welcome! :)</div>';
		$session->login($found_user);
		header("Location: index.php");		
	} else {
		$email = '';
		$password = '';
		$_SESSION['msg'] = '';
	}
}

require_once('templates/header.php');

?>

			<div class="container">
				<div class="row">
			  	<div class="col-md-4"></div>
			  	<div class="col-md-4">
			  		<h2>Register</h2>
						<form id="registerForm" action="#" method="POST">
						  <div class="form-group">
						    <label for="InputUsername">Your Username</label>
						    <input type="text" class="form-control" id="InputUsername" name="username">
						  </div>
						  <div class="form-group">
						    <label for="InputEmail">Your Email address</label>
						    <input type="email" class="form-control" id="InputEmail" name="email" onblur="isUnique(this.value)">
						    <p id='validateEmail'></p>
						    <p id='validateEmail2'></p>
						  </div>
						  <div class="form-group">
						    <label for="InputPassword">Your Password</label>
						    <input type="password" class="form-control" id="InputPassword" name="password">
						  </div>
						  <div class="form-group">
						    <label for="ConfirmPassword">Confirm Password</label>
						    <input type="password" class="form-control" id="ConfirmPassword" name="confirmPassword">
						    <p id='validatePassword'></p>
						  </div>
						  <button type="submit" id="submit" class="btn btn-default">Submit</button>
						</form>
						<h4>Already have an account? <a href="login.php">Log In.</a></h4>
			  	</div>
			  	<div class="col-md-4"></div>
			  </div>
			</div>
		</main>
		<footer class="footer">
		  <div class="container">
		  	<div class="row">
		  		<ul class="nav navbar-nav">		
					<li><a>Copyright 2017 TM</a></li>
					</ul>
				</div>
			</div>
		</footer>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="assets/js/register.js"></script>
	</body>
</html>