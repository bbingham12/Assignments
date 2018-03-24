<html>
<body>


Welcome <?php echo $_POST["f_name"]?> <?php echo $_POST["l_name"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?><br>
your favoite number is: <?php echo $_POST["favnumber"]; ?><br>
your birthday is: <?php echo $_POST["birthday"]; ?><br>

<?php
	// This function will run within each post array including multi-dimensional arrays 
	function ExtendedAddslash(&$params)
	{ 
	        foreach ($params as &$var) {
	            // check if $var is an array. If yes, it will start another ExtendedAddslash() function to loop to each key inside.
	            is_array($var) ? ExtendedAddslash($var) : $var=addslashes($var);
	            unset($var);
	        }
	} 

	// Initialize ExtendedAddslash() function for every $_POST variable
	ExtendedAddslash($_POST);      

	//store post data to array
	$f_name=$_POST['f_name'];
	$l_name=$_POST['l_name'];
	$email=$_POST['email'];
	$favnumber=$_POST['favnumber'];
	$birthday=$_POST['birthday'];



	$connect=mysqli_connect('localhost','root','root','friends') or die(mysqli_error());

	//checking for friends table and creating new table if it doesnt exist
	if ($connect->query("select * from friends") === FALSE) {
		$sql = "CREATE TABLE `friends`.`friends` 
		( `friend_id` INT(6) UNSIGNED AUTO_INCREMENT, 
		`f_name` VARCHAR(15) NOT NULL , 
		`l_name` VARCHAR(25) NOT NULL , 
		`email` VARCHAR(40) NOT NULL , 
		`favnumber` INT NOT NULL , 
		`birthday` DATE NOT NULL , 
		PRIMARY KEY (`friend_id`)) ENGINE = InnoDB;";

		if (mysqli_query($connect, $sql)) {
		    echo "Table friends created successfully";
		} else {
		    echo "Error creating table: " . mysqli_error($connect);
		}

	}
	
	// search submission ID

	$query = "SELECT friend_id FROM `friends` WHERE `email` = '$email'";
	$result  = mysqli_query($connect,$query);
	$friend_check = mysqli_num_rows($result );
	$row= mysqli_fetch_array($result);
	$friend_id = $row['friend_id'];
	echo $friend_id;

	if ($friend_check > 0) {
	 
	    mysqli_query($connect, "UPDATE `friends` SET 
	                                `f_name` = '$f_name',
	                                `l_name` = '$l_name',
	                                `email` = '$email',
	                                `favnumber` = '$favnumber',
	                                `birthday` = '$birthday'
	                                      
	                            WHERE  friend_id = '$friend_id'") 
	     						or die(mysqli_error());
	    echo "friend info updated";
	    
	} else {

	    mysqli_query($connect, "INSERT INTO `friends`(`friend_id`, `f_name`, `l_name`, `email`, `favnumber`, `birthday`) VALUES ('','$f_name', '$l_name', '$email', '$favnumber', '$birthday') ");

	   	echo "new friend stored";

	}

	header('Location: friendsForm.php');
	echo "<a href='friendsForm.php'>Add another friend... </a><br>";
?>



</body>
</html>


