<!-- This PHP file cointains a php function that adds user form input from 
   familyForm.php to a sql table. I referenced Rebecca Follman's saveAuthor.php as a guide/template.
   -->
<html>
   <body>

      <?php  
         //store post data to array
         $f_name=$_POST['f_name'];
         $l_name=$_POST['l_name'];
         $email=$_POST['email'];
         $familyFriend=$_POST['familyFriend'];
         $relationship=$_POST['relationship'];
         $birthday=$_POST['birthday'];
         
         
         
         // creating connection for family database
         $connect=mysqli_connect('localhost','root','root','friends') or die(mysqli_error());
         
         //checking for family table and creating new table if it doesnt exist
         if ($connect->query("select * from family") === FALSE) {
            $sql = "CREATE TABLE `friends`.`family` 
            ( `family_id` INT(6) UNSIGNED AUTO_INCREMENT, 
            `f_name` VARCHAR(15) NOT NULL , 
            `l_name` VARCHAR(25) NOT NULL , 
            `email` VARCHAR(40) NOT NULL , 
            `familyFriend` INT(6) UNSIGNED , 
            `relationship` VARCHAR(25) NOT NULL ,
            `birthday` DATE NOT NULL ,
            FOREIGN KEY (`familyFriend`) REFERENCES friends(friend_id) ,
            PRIMARY KEY (`family_id`)) ENGINE = InnoDB;";
         
            if (mysqli_query($connect, $sql)) {
                echo "Table family created successfully";
            } else {
                echo "Error creating table: " . mysqli_error($connect);
            }
         }
         
         // search family database
         $query = "SELECT family_id FROM `family` WHERE `email` = '$email'";
         $result  = mysqli_query($connect,$query);
         $family_check = mysqli_num_rows($result );
         $row= mysqli_fetch_array($result);
         $family_id = $row['family_id'];
         echo $family_id;
         
         // check for existing family_id
         if ($family_check > 0) {
              // updates existing family info in database
             mysqli_query($connect, "UPDATE `family` SET 
                                         `f_name` = '$f_name',
                                         `l_name` = '$l_name',
                                         `email` = '$email',
                                         `familyFriend` = '$familyFriend',
                                         `relationship` = '$relationship',                    
                                         `birthday` = '$birthday'    
                                     WHERE  family_id = '$family_id'") 
                                    or die(mysqli_error());
             echo "family info updated";
             
         } else {
             // adds a new family member to database
             mysqli_query($connect, "INSERT INTO `family`(`family_id`, `f_name`, `l_name`, `email`, `familyFriend`, `relationship`, `birthday`) VALUES ('','$f_name', '$l_name', '$email', '$familyFriend', '$relationship', '$birthday') ");
         
                echo "new family stored";
         }

         // returns to familyForm
         header('Location: familyOfFriends.php');
         echo "<a href='familyOfFriends.php'>Add another family... </a><br>";
         
         ?>
   </body>
</html>