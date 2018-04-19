<!-- This PHP file cointains a html form that submits form data to savefamily.php and displays the 
	database info in a table. I referenced Rebecca Follman's sampleform.php as a guide/template.
	  -->
<?php 
	/* Sample form using bootstrap */
	include 'resources/bslinks.php';
	
	// creating connection to SQL
	$conn = new mysqli('localhost', 'root', 'root', 'friends');
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
	
	// select query to gather existing family info from family and friends database
	$a = "select * from friends order by l_name, f_name";
	$f = "SELECT family.*, friends.f_name as ff_name, friends.l_name as fl_name FROM `family` JOIN friends on family.familyFriend = friends.friend_id";
	
	// saving queries
	$friends = $conn->query($a);
	$family = $conn->query($f);
	
	$row = null; //in case no firends data requested
	
	//get family data if requested
	if ($_GET['fid']) {
		$fidq = "select * from family where family_id = " . $_GET['fid'];
		$ar = $conn->query($fidq);
		$row = $ar->fetch_assoc();
	}

	?>	
<!DOCTYPE html>
<html>
	<head>
		<title>Add a Family Member of a Friend</title>
		<link rel="stylesheet" href="css/main-php.css">
	</head>
	<body>
		<div class="content">
			<div class="container">
				<div class="row">
					<h1 align="center">Enter Family Member of a Friend's Info</h1>
					<br>
					<form style="width: 100%"" action="saveFamily.php" method="post" class="form-horizontal">
						<input id="family_id" type="hidden" name="family_id" value="<?=$row['family_id']?>">
						<!-- form input gathers family members name -->
						<div class="form-group">
							<label for="f_name" class="control-label col-sm-3">Family Member's Name</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="f_name" name="f_name" placeholder="First Name" value="<?=$row['f_name']?>" maxlength="25" required>
							</div>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="l_name" name="l_name" placeholder="Last Name" maxlength="35" value="<?=$row['l_name']?>" required>
							</div>
						</div>
						<!-- form dropdown containing db list of friend names from friends. -->
						<div class="form-group">
							<label for="familyFriend" class="control-label col-sm-3">Related to:</label>
							<div class="col-sm-4">
								<select name="familyFriend" id="familyFriend" class="form-control" required="required">
									<option value="" selected="selected">Please make a choice</option>
									<?php foreach ($friends as $r): ?>
									<?php if ($r['friend_id'] == $row['friends']): ?>
									<option value="<?=$r['friend_id']?>" selected="selected"><?=$r['l_name'] . ", " . $r['f_name']?></option>
									<?php else: ?>
									<option value="<?=$r['friend_id']?>"><?=$r['l_name'] . ", " . $r['f_name']?></option>
									<?php endif ?>
									<?php endforeach ?>
								</select>								
							</div>
							<div class="col-sm-5">
								<a href="friendsForm.php" class="btn btn-warning">Add Friend Related to this Family Member</a>
							</div>
						</div>
						<!-- form input gathers email -->
						<div class="form-group">
							<label for="email" class="control-label col-sm-3">Email</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="email" name="email" placeholder="Email"  value="<?=$row['email']?>" maxlength="40" required>
							</div>
						</div>
						<!-- form drop down input gathers relationship if family member to firend -->
						<div class="form-group">
							<label for="relationship" class="control-label col-sm-3">Relationship to Friend</label>
							<div class="col-sm-4">
								<select name="relationship" id="relationship" class="form-control" required="required">
									<option value="Brother">Brother</option>
									<option value="Sister">Sister</option>
									<option value="Dad">Dad</option>
									<option value="Mom">Mom</option>
									<option value="Aunt">Aunt</option>
									<option value="Uncle">Uncle</option>
									<option value="Grandfather">Grandfather</option>
									<option value="Grandmother">Grandmother</option>
									<option value="Son">Son</option>
									<option value="Daughter">Daughter</option>
									<option value="In-Law">In-Law</option>
									<option value="Other">Other</option>
								</select>	
							</div>
						</div>
						<!-- form input gather birthday info -->
						<div class="form-group">
							<label for="birthday" class="control-label col-sm-3">Birthday</label>
							<div class="col-sm-6">
								<input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday  (YYYY-MM-DD)"  value="<?=$row['birthday']?>" required>
							</div>
						</div>
						<div class="col-sm-4 col-sm-offset-2">
							<div class="submit">
								<input type="submit" value="Add Family Member" class="btn btn-info pull-right">
							</div>
						</div>
						<div class="col-sm-4">
							<a href="tableInfo.php" class="btn btn-warning pull-right">Show Table Details</a>
						</div>
				</div>
				</form>
				<section class="col-md-20 col-sm-offset-0">
					<h2>Current Family Members of Friends</h2>
					<?php if ($friends): ?>
					<!-- creating table to show family info from family database -->
					<table class="small table table-condensed table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Friend related too</th>
								<th>Relation to friend</th>
								<th>Birthday</th>
							</tr>
						</thead>
						<tbody>
							<!-- loops through rows in family members databse and prints thier info to table -->
							<?php foreach ($family as $r): ?>
							<tr>
								<td><a href="familyOfFriends.php?fid=<?=$r['family_id']?>"><?=$r['f_name'] . " " . $r['l_name']?></a></td>
								<td><?=$r['email']?></td>
								<td><?=$r['ff_name'] . " " . $r['fl_name']?></a></td>
								<td><?=$r['relationship']?></td>
								<td><?=$r['birthday']?></td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					<!-- if nothing exist in family database, "no records" is displayed -->
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