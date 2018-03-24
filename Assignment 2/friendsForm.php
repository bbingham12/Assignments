<html>
<head>


	<script type="text/javascript">

	// temp vars for validation
	var f_name = ['20', 'First name must be 20 characters or less.'];
	var l_name = ['30', 'Last name must be 30 characters or less.'];
	var email = ['40', 'Email addreess must be 40 characters or less.'];
	var favnumber = ['64', 'Favorite number must be a whole integer'];
	var birthday = ['10', 'Birthday must be in proper date format (YYYY-MM-DD)'];
	
	// this javascript function checks form data for validation.
	function validText(text, name) {
		console.log(window[name][1]);
		var len = text.length;
		if (len > window[name][0]) {
			//do something
			document.getElementById(name + "err").innerHTML = window[name][1];
		}
		console.log(len);
	};
	</script>

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
		mysqli_close($conn);

		//opening newly created database
		$conn = new mysqli('localhost', 'root', 'root', 'friends');
		if ($conn->connect_error) die($conn->connect_error);

		$a = "select * from friends order by l_name, f_name";
		
		$result = $conn->query($a);

		$row = null; //in case no author data requested

		//get authors data if requested
		if ($_GET['aid']) {
			$aidq = "select * from friends where friend_id = " . $_GET['aid'];
			$ar = $conn->query($aidq);
			$row = $ar->fetch_assoc();
		}
	?>	

	<link rel="stylesheet" href="css/main-php.css">
</head>
<body>
	<div class="content">
		<div class="container">
			<div class="row">
				<h1 align="center">Enter Friends Name</h1><br>
				<form action="saveFriend.php" method="post" class="form-horizontal">
					<input id="friend_id" type="hidden" name="friend_id" value="<?=$row['friend_id']?>">
					<div class="form-group">
						<label for="f_name" class="control-label col-sm-3">Friend's Name</label>
						<div class="col-sm-4">
							<input type="text" onchange="validText(this.value, this.name)"  class="form-control" id="f_name" name="f_name" placeholder="First Name" value="<?=$row['f_name']?>" maxlength="25" required>
						</div>
						<div class="col-sm-5">
							<input type="text" onchange="validText(this.value, this.name)"  class="form-control" id="l_name" name="l_name" placeholder="Last Name" maxlength="35" value="<?=$row['l_name']?>" required>
						</div>
					</div>

					<div class="form-group">
						<label for="email" class="control-label col-sm-3">Email</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="email" name="email" placeholder="Email" onchange="validText(this.value, this.name)" value="<?=$row['email']?>" maxlength="40" required>
						</div>
					</div>

					<div class="form-group">
						<label for="favnumber" class="control-label col-sm-3">Favorite Number</label>
						<div class="col-sm-6">
							<input type="number" class="form-control" id="favnumber" name="favnumber" placeholder="Favorite Number" onchange="validText(this.value, this.name)" value="<?=$row['favnumber']?>" maxlength="64" required>
						</div>
					</div>

					<div class="form-group">
						<label for="birthday" class="control-label col-sm-3">Birthday</label>
						<div class="col-sm-6">
							<input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday  (YYYY-MM-DD)" onchange="validText(this.value, this.name)" value="<?=$row['birthday']?>" maxlength="10" required>
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
					<table class="small table table-condensed table-striped">
						<thead><tr><th>Name</th><th>Email</th><th>Favorite #</th><th>Birthday</th></tr></thead>
						<tbody>
							<?php foreach ($result as $r): ?>
								<tr><td><a href="friendsForm.php?aid=<?=$r['friend_id']?>"><?=$r['f_name'] . " " . $r['l_name']?></a></td><td><?=$r['email']?></td><td><?=$r['favnumber']?></td><td><?=$r['birthday']?></td></tr>
							<?php endforeach ?>
						</tbody>
					</table>
				<?php else: ?>
					<p>No records</p>
				<?php endif ?>
				</section>
			</div> <!-- row -->
		</div> <!-- container -->
	</div> <!-- content -->


	<?php include 'resources/bsfooter.php';?>	

</body>
</html>