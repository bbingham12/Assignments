<!-- This PHP file cointains a html form that submits form data tosaveFriend.php and displays the 
	database info in a table. I referenced Rebecca Follman's sampleform.php as a guide/template.
   -->

<html>
   <head>

      <title>Friends PHP Form</title>

      <?php 
         /* Sample form using bootstrap */
         include 'resources/bslinks.php';
         
         // creating connection to SQL
         $conn = new mysqli('localhost', 'root', 'root', 'library');
         if ($conn->connect_error) die($conn->connect_error);
         
         // Create database
         $sql = "CREATE DATABASE friends";
         if ($conn->query($sql) === TRUE) {
             echo "Database created successfully";
         }
         //close old database
         mysqli_close($conn);
         
         //opening newly created database
         $conn = new mysqli('localhost', 'root', 'root', 'friends');
         if ($conn->connect_error) die($conn->connect_error);
         
         // select query to gather existing friends info from friends database
         $a = "select * from friends order by l_name, f_name";
         // saving query results
         $result = $conn->query($a);
         
         $row = null; //in case no firends data requested
         
         //get friends data if requested
         if ($_GET['fid']) {
         	$fidq = "select * from friends where friend_id = " . $_GET['fid'];
         	$ar = $conn->query($fidq);
         	$row = $ar->fetch_assoc();
         }
         ?>	
      <link rel="stylesheet" href="css/main-php.css">
   </head>
   <body>
      <div class="content">
         <div class="container">
            <div class="row">
               <h1 align="center">Enter Friends Info</h1>
               <br>
               <form action="saveFriend.php" method="post" class="form-horizontal">
                  <input id="friend_id" type="hidden" name="friend_id" value="<?=$row['friend_id']?>">
                  <div class="form-group">
                     <label for="f_name" class="control-label col-sm-3">Friend's Name</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" id="f_name" name="f_name" placeholder="First Name" value="<?=$row['f_name']?>" maxlength="25" required>
                     </div>
                     <div class="col-sm-5">
                        <input type="text"  class="form-control" id="l_name" name="l_name" placeholder="Last Name" maxlength="35" value="<?=$row['l_name']?>" required>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="email" class="control-label col-sm-3">Email</label>
                     <div class="col-sm-6">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email"  value="<?=$row['email']?>" maxlength="40" required>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="favnumber" class="control-label col-sm-3">Favorite Number</label>
                     <div class="col-sm-6">
                        <input type="number" class="form-control" id="favnumber" name="favnumber" placeholder="Favorite Number"  value="<?=$row['favnumber']?>" maxlength="64" required>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="birthday" class="control-label col-sm-3">Birthday</label>
                     <div class="col-sm-6">
                        <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday  (YYYY-MM-DD)"  value="<?=$row['birthday']?>" required>
                     </div>
                  </div>
                  <div class="col-sm-4 col-sm-offset-2">
                     <div class="submit">
                        <input type="submit" value="Add Friend" class="btn btn-info pull-right">
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <a href="tableInfo.php" class="btn btn-warning pull-right">Show Table Details</a>
                  </div>
            </div>
            </form>
            <section class="col-sm-12 col-sm-offset-0">
               <h2>Current Friends</h2>
               <?php if ($result): ?>
               	 <!-- creating table to show friends info from friend database -->
               <table class="small table table-condensed table-striped">
                  <thead>
                     <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Favorite #</th>
                        <th>Birthday</th>
                     </tr>
                  </thead>
                  <tbody>
                  	<!-- loops through rows in freidns databse and prints firends info to table -->
                     <?php foreach ($result as $r): ?>
                     <tr>
                        <td><a href="friendsForm.php?fid=<?=$r['friend_id']?>"><?=$r['f_name'] . " " . $r['l_name']?></a></td>
                        <td><?=$r['email']?></td>
                        <td><?=$r['favnumber']?></td>
                        <td><?=$r['birthday']?></td>
                     </tr>
                     <?php endforeach ?>
                  </tbody>
               </table>
               <!-- if nothing exist in friends database, "no records" is displayed -->
               <?php else: ?>
               <p>No records</p>
               <?php endif ?>
            </section>
         </div>
         <!-- row -->
      </div>
      <!-- container -->
      </div> <!-- content -->
      <?php include 'resources/bsfooter.php';?>	
   </body>
</html>