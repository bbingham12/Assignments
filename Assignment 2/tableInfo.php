<html>
	<head>
		<title>Table Information</title>
		<?php 
			include 'resources/bslinks.php';

			//creating sql connection
			$conn = new mysqli('localhost', 'root', 'root', 'friends');
			if ($conn->connect_error) die($conn->connect_error);
		
			// gathering data from table
			$query = "select * from friends";
			$result = $conn->query($query);
			$finfo = $result->fetch_fields();
			$rows = $result->num_rows;
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
				<div class="row">
					<h1 align = 'center'>Table Data</h1>
					<?php if ($result): ?>
						<section class="col-sm-6 col-sm-offset-3">
						<table class="small table table-condensed table-striped">
							<thead>
								<tr><th>Field Name</th><th class="text-right">Length</th><th class="text-right">Data Type</th></tr>
							</thead>
							<tbody>
								<?php foreach ($finfo as $r): ?>
									<tr><td><?=$r->name?></td><td class="text-right"><?=$r->length?></td><td class="text-right"><?=transType($r->type)?></td></tr>
								<?php endforeach ?>
							</tbody>
						</table>
						<blockquote><h4>There are <?=$rows?> rows in the friends table.</h4></blockquote>
						<a href="friendsForm.php" class="btn btn-info pull-right">Add or update a New friend</a>
						</section>
					<?php endif ?>
				</div>
			</div>
		</div>
		<?php include 'resources/bsfooter.php'; ?>
	</body>
</html>
