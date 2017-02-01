
<?php
require_once('../src/Session.php');

$output = "";

if(!empty($_SESSION['username'])) {
	$output .= '<li><a>Logged in as ' . 
	$_SESSION["username"] . ' (id: '.$_SESSION["id"].')</a></li>';
	$output .= '<li><a href="logout.php">Logout</a></li>';
} else {
	$output .= '<li><a href="login.php">Log in</a></li>';
	$output .= '<li><a href="register.php">Register</a></li>';
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Twitter</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
		<header>
		  <div class="container">
		  	<div class="row">
		    	<div class="col-md-12">
						<nav class="navbar navbar-default">
						  <div class="container-fluid">
						    <div class="navbar-header">
						      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						        <span class="sr-only">Toggle navigation</span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						      </button>
						      <a class="navbar-brand" href="index.php">Twitter</a>
						    </div>
						    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						      <ul class="nav navbar-nav">
						        <li><a href="profile.php">
						        Your profile
						        <span class="sr-only">(current)</span></a></li>
						      </ul>
						      <ul class="nav navbar-nav navbar-right">

						      	<?php echo $output ?>
						      	
						      </ul>
						    </div>
						  </div>
						</nav>
		    	</div>
		    </div>
		  </div>
		</header>
		<main>