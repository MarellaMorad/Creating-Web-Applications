<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="PHP Connection to MySQL DB">
    <meta name="keywords" content="PHP, DB, MySQL">
    <meta name="author" content="Marella Morad">
    <link rel="stylesheet" href="addcar.css" type="text/css">
    <title>Add Cars to DB</title>
</head>

<body>
    <?php 
        require_once("settings.php"); //connection info

        $conn = @mysqli_connect($host, $user, $pwd, $sql_db); // mysqli_connect command t crate a connection to the database from PHP

        //Checks if connection is successful
        if (!$conn) {
            //Display an error message
            echo "<p>Database connection failure</p>"; //not in production script
        } else {
            //assign the values from the 'post' into the variables
            $make = trim(htmlspecialchars($_POST["carmake"]));
            $model = trim(htmlspecialchars($_POST["carmodel"]));
            $price = trim(htmlspecialchars($_POST["price"]));
            $yom = trim(htmlspecialchars($_POST["yom"]));

            $sql_table = "cars";
            $query = "insert into $sql_table (make, model, price, yom) values ('$make', '$model', '$price', '$yom')";

            //execute the query - we should really check to see if the database exists first.
            $result = mysqli_query($conn, $query);
            
            //checks if the execution was successful
            if (!$result) {
                echo "<p class=\"wrong\">Something is wrong with ", $query, "</p>";
            } else {
                // display an operation successful message
                echo "<p class=\"ok\">Successfully added New Car record</p>";
            } // if successful query operation
            //close database connection
            mysqli_close($conn);
        } //if successful database connection
    ?>
</body>

</html>