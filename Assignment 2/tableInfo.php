<!-- This PHP file creates a table decscribing friends table from saveFriend.php
	I referenced Rebecca Follman's tableinfo.php as a guide/template.
 -->

<html>
	<head>
		<title>Table Information</title>
		<?php 
			include 'resources/bslinks.php';

			//creating sql connection to friends database
			$conn = new mysqli('localhost', 'root', 'root', 'friends');
			if ($conn->connect_error) die($conn->connect_error);
		
			// gathering data from friends database
			$friquery = "select * from friends";
			$famquery = "select * from family";
			$friresult = $conn->query($friquery);
			$famresult = $conn->query($famquery);
			$friinfo = $friresult->fetch_fields();
			$faminfo = $famresult->fetch_fields();
			$frirows = $friresult->num_rows;
			$famrows = $famresult->num_rows;
			function transType($t) {
				switch ($t) {
					case '3':
						return 'Long';
						break;
					case '253':
						return 'Varchar';
						break;
					default:
						return 'Error';
						break;
				}
			}
		?>		
		<link rel="stylesheet" href="css/main-php.css">
	</head>
	<body>
		<div class="content">
			<div class="container">
				<!-- creating html table to display friends table stats -->
				<div class="row">
					<h1 align = 'center'>Friends Table Data</h1>
					<?php if ($friinfo): ?>
						<section class="col-sm-6 col-sm-offset-3">
						<table class="small table table-condensed table-striped">
							<thead>
								<tr><th>Field Name</th><th class="text-right">Length</th><th class="text-right">Data Type</th></tr>
							</thead>
							<tbody>
								<?php foreach ($friinfo as $r): ?>
									<tr><td><?=$r->name?></td><td class="text-right"><?=$r->length?></td><td class="text-right"><?=transType($r->type)?></td></tr>
								<?php endforeach ?>
							</tbody>
						</table>
						<blockquote><h4>There are <?=$frirows?> rows in the friends table.</h4></blockquote>
						<a href="friendsForm.php" class="btn btn-info pull-right">Add or update a New friend</a>
						</section>
					<?php endif ?>
				</div>
				<!-- creating html table to display family table stats -->
				<div class="row">
					<h1 align = 'center'>Family Table Data</h1>
					<?php if ($faminfo): ?>
						<section class="col-sm-6 col-sm-offset-3">
						<table class="small table table-condensed table-striped">
							<thead>
								<tr><th>Field Name</th><th class="text-right">Length</th><th class="text-right">Data Type</th></tr>
							</thead>
							<tbody>
								<?php foreach ($faminfo as $r): ?>
									<tr><td><?=$r->name?></td><td class="text-right"><?=$r->length?></td><td class="text-right"><?=transType($r->type)?></td></tr>
								<?php endforeach ?>
							</tbody>
						</table>
						<blockquote><h4>There are <?=$famrows?> rows in the family table.</h4></blockquote>
						<a href="friendsForm.php" class="btn btn-info pull-right">Add or update a New Family Member</a>
						</section>
					<?php endif ?>
				</div>
			</div>
		</div>
		<?php include 'resources/bsfooter.php'; ?>
	</body>
</html>
