<!-- This PHP file cointains a php function that adds user form input from 
   friendsForm.php to a sql table. I referenced Rebecca Follman's saveAuthor.php as a guide/template.
   -->
   
<html>
   <body>

      <?php  
         
         //store post data to array
         $f_name=$_POST['f_name'];
         $l_name=$_POST['l_name'];
         $email=$_POST['email'];
         $favnumber=$_POST['favnumber'];
         $birthday=$_POST['birthday'];
         
         
         // creating connection for friends database
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
         
         // search friends database
         $query = "SELECT friend_id FROM `friends` WHERE `email` = '$email'";
         $result  = mysqli_query($connect,$query);
         $friend_check = mysqli_num_rows($result );
         $row= mysqli_fetch_array($result);
         $friend_id = $row['friend_id'];
         echo $friend_id;
         
         // check for existing friend_id
         if ($friend_check > 0) {
              // updates existing friend info in database
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
             // adds a news friends to database
             mysqli_query($connect, "INSERT INTO `friends`(`friend_id`, `f_name`, `l_name`, `email`, `favnumber`, `birthday`) VALUES ('','$f_name', '$l_name', '$email', '$favnumber', '$birthday') ");
         
            	echo "new friend stored";
         
         }
         // returns to friendsForm
         header('Location: friendsForm.php');
         echo "<a href='friendsForm.php'>Add another friend... </a><br>";
         ?>
   </body>
</html>