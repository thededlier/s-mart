<?php
    include './process/common/item_lookup.php';

    session_start();

    echo $_SESSION["pid1"] . "<br>" . $_SESSION["pid2"];
    session_destroy();
?>

<html>
	<head>
		<title>S-MART</title>

	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	</head>

    <body>
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
