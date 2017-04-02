<?php
    session_start();

    $pid = $_POST["product_id"];
    if(!isset($_SESSION["pid1"])) {
        $_SESSION["pid1"] = $pid;
        header("Location: ../../search-results.php");
    } else if(!isset($_SESSION["pid2"])) {
        $_SESSION["pid2"] = $pid;
        unset($_POST["compare_button"]);
        header("Location: ../../compare-products.php");
    }
?>
