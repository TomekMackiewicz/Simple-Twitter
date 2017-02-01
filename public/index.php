<?php
require_once('../src/Session.php');
require_once('../src/Tweet.php');
require_once('../src/User.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_POST)) {
		$tweet = new Tweet;
		$tweet->setUserID($_SESSION['id']);
		$tweet->setText($_POST['tweetText']);
		$tweet->setCreationDate();
		$tweet->saveToDB($conn);
		$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Tweet added successfully.</div>';
	}
}

$allTweets = Tweet::loadAllTweets($conn);
$tweets = "";

foreach ($allTweets as $tweet) {
	$author = User::loadUserById($conn,$tweet->getUserID());						  
  $tweets .= '<tr>';
  $tweets .= '<td>' . $tweet->getUserID() . '</td>';
  if($_SESSION['id'] == $tweet->getUserID()) {
  	$tweets .= '<td>'.$author->getUsername().'</td>';
  } else {
  	$tweets .= '<td><a href="userProfile.php?id='.$tweet->getUserID().'">'.$author->getUsername().'</a></td>';
  }
  $tweets .= '<td>' . $tweet->getText() . '</td>';
  $tweets .= '<td>' . $tweet->getCreationDate() . '</td>';
  $tweets .= '<td><a href="details.php?id='.$tweet->getID().'">Show</a></td>';
  $tweets .= '</tr>';
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
  	<div class="col-md-12">
    	<h2>Add new Tweet</h2>

    	<?php echo $message ?>
    	<?php unset($_SESSION['msg']) ?>
    	
			<form action="#" method="POST">
			  <div class="form-group">
			    <label for="tweetText">Tweet text</label>
			    <textarea class="form-control" id="tweetText" name="tweetText" maxlength="200"></textarea>
			  </div>
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
  	</div>
  </div>		  
	<div class="row">
  	<div class="col-md-12">
  		<h2>All Tweets</h2>
			<table class="table">
				<tr>
					<th>User ID</th>
					<th>Author</th>
					<th>Text</th>
					<th>Date</th>
					<th>Show</th>
				</tr>

  			<?php echo $tweets; ?>

			</table>
  	</div>
  </div>
</div>

<?php require_once('templates/footer.php'); ?>