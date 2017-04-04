<?php
    include './process/common/item_lookup.php';

    session_start();

    // session_destroy();
?>

<html>
	<head>
		<title>S-MART</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>S-MART</title>

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

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toogle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">S-MART BAZAAR</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#"> <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a></li>
                        <li><a href="#"> <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> About</a></li>
                        <li><a href="#"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Feedback</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Contact</a></li>
                    </ul>
                </div>
            </div>
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
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <?php
                        $html = itemLookup($_SESSION["pid1"]);
                        echo $html;
                    ?>
                </div>

                <div class="col-md-6">
                    <?php
                        $html = itemLookup($_SESSION["pid2"]);
                        echo $html;
                    ?>
                </div>
            </div>
        </div>
    </body>

</html>
