<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="PHP Connection to MySQL DB">
    <meta name="keywords" content="PHP, DB, MySQL">
    <meta name="author" content="Marella Morad">
    <link rel="stylesheet" href="addcar.css" type="text/css">
    <title>Search for Cars in DB</title>
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

            // Build the query string based on which filters were provided

            $selectedFilters = false;

            $query = "SELECT * FROM cars WHERE ";
            $queryCount = "SELECT Count(*) FROM cars WHERE ";
            $conditions = array();
            if (!empty($make)) {
                $conditions[] = "make like '%$make%'";
                $selectedFilters = true;
            }

            if (!empty($model)) {
                $conditions[] = "model like '%$model%'";
                $selectedFilters = true;
            }
            
            if (!empty($price)) {
                $conditions[] = "price like '%$price%'";
                $selectedFilters = true;
            }

            if (!empty($yom)) {
                $conditions[] = "yom like '%$yom%'";
                $selectedFilters = true;
            }

            $query .= implode(" AND ", $conditions);
            $queryCount .= implode(" AND ", $conditions);

            //execute the query - we should really check to see if the database exists first.
            if ($selectedFilters) {
                $result = mysqli_query($conn, $query);
                $resultCount = mysqli_query($conn, $queryCount);

                $resultCountRow = mysqli_fetch_assoc($resultCount);

                //checks if the execution was successful
                if ($resultCountRow["Count(*)"] == 0) {
                    echo "<p class=\"wrong\">No results found!</p>";
                } else {
                    // display an operation successful message
                    echo "<p class=\"ok\">", $resultCountRow["Count(*)"], " Result/s Found</p>";

                    //Display the retrieved records
                    echo "<table border=\"1\">\n";
                    echo "<tr>\n "
                        ."<th scope=\"col\">Make</th>\n "
                        ."<th scope=\"col\">Model</th>\n "
                        ."<th scope=\"col\">Price</th>\n "
                        ."<th scope=\"col\">Year of Manufacturing</th>\n "
                        ."</tr>\n ";

                    //retrieve current record pointed by the result pointer
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>\n ";
                        echo "<td>", $row["make"],"</td>\n ";
                        echo "<td>", $row["model"],"</td>\n ";
                        echo "<td>", $row["price"],"</td>\n ";
                        echo "<td>", $row["yom"],"</td>\n ";
                        echo "</tr>\n ";
                    }

                    echo "</table>\n ";

                    //Frees up the memory, after using the result pointer
                    mysqli_free_result($result);
                } // if successful query operation
                //close database connection
                mysqli_close($conn);
            } else {
                echo "<p class=\"wrong\">No filters were selected!</p>";
            }
        } //if successful database connection
    ?>
</body>

</html>