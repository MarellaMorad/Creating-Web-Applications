<?php 
    session_start();
    if (!isset($_SESSION["number"])) {
        $_SESSION["number"] = 0;
    }

    $num = $_SESSION["number"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Managing State and SQL Injection">
    <meta name="keywords" content="PHP, DB, MySQL">
    <meta name="author" content="Marella Morad">
    <title>PHP Sessions Lab</title>
</head>

<body>
    <h1>Creating Web Applications - PHP Sessions Lab</h1>
    <?php 
        echo "<p>The number is ", $num, "</p>";
    ?>

    <p><a href="numberup.php">Up &#x2191;</a></p>
    <p><a href="numberdown.php">Down &#x2193;</a></p>
    <p><a href="numberreset.php">Reset</a></p>
</body>

</html>