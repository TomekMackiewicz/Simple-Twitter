<?php
require_once('../src/Config.php');

if(isset($_POST['email'])) {
	$sql = "SELECT * FROM Users WHERE email=? LIMIT 1";
	try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_POST['email']]);
		if($stmt == true && $stmt->rowCount() > 0) {
			echo "Email already exists. Forgot password?";
		} else {
			return null;
		}
		return null;
	} catch (PDOException $e) {
	    echo("Błąd: " . $e->getMessage());
	}
}

?>