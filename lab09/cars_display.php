<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="PHP Connection to MySQL DB">
    <meta name="keywords" content="PHP, DB, MySQL">
    <meta name="author" content="Marella Morad">
    <title>Retrieving records to HTML</title>
</head>

<body>
    <h1>Creating Web Applications - Lab09</h1>
    <?php
        require_once("settings.php"); //connection info

        $conn = @mysqli_connect($host, $user, $pwd, $sql_db); // mysqli_connect command t crate a connection to the database from PHP

        //Checks if connection is successful
        if (!$conn) {
            //Display an error message
            echo "<p>Database connection failure</p>"; //not in production script
        } else {
            //Upon successful connection
            $sql_table = "cars";

            // Set up the SQL command to query or add data into the table
            $query = "select make, model, price FROM cars ORDER BY make, model";

            // execute the query and store result into the result pointer
            $result = mysqli_query($conn, $query);

            //checks if the execution was successful
            if (!$result) {
                echo "<p>Something is wrong with ", $query, "</p>";
            } else {
                //Display the retrieved records
                echo "<table border=\"1\">\n";
                echo "<tr>\n "
                    ."<th scope=\"col\">Make</th>\n "
                    ."<th scope=\"col\">Model</th>\n "
                    ."<th scope=\"col\">Price</th>\n "
                    ."</tr>\n ";

                //retrieve current record pointed by the result pointer
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>\n ";
                    echo "<td>", $row["make"],"</td>\n ";
                    echo "<td>", $row["model"],"</td>\n ";
                    echo "<td>", $row["price"],"</td>\n ";
                    echo "</tr>\n ";
                }

                echo "</table>\n ";

                //Frees up the memory, after using the result pointer
                mysqli_free_result($result);
            } // if successful query operation

            //close database connection
            mysqli_close($conn);
        } //if successful database connection
    ?>
</body>

</html>