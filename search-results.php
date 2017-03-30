<?php 
    include './process/common/item_search.php'
?>

<html>
	<head>
		<title>S-MART</title>

	    <meta charset="utf-8">	
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Minor Project Homepage</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Crete+Round|Revalia|Arvo|Pavanam" rel="stylesheet">
		<link href="css/mystyles.css" rel="stylesheet">
		<link href="css/mystyle.css" rel="stylesheet">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="https://use.fontawesome.com/ab12edd70a.js"></script>
	</head>

	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<form action="search-results.php" method="POST">
						<div class="form-group col-md-7">
							<input type="text" class="form-control" id="search_item" name="search_item" placeholder="Search...."></input>
						</div>
						<div class="form-group col-md-3">
							<select class="form-control" name="category">
								<option value="Electronics">Electronics</option>
							</select>
						</div>
						<div class="col-md-2">
							<button class="btn btn-default btn-block" type="submit" name="simple_search">Search</button>
					</form>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<?php
					if(isset($_POST["simple_search"])) {
						$searchIndex = $_POST["category"];
						$keywords = $_POST["search_item"];
						itemSearch($searchIndex, $keywords);
					}
				?>
			</div>
		</div>	
	</body>
</html>