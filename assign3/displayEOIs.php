<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Creating Web Applications">
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP, SQL">
    <meta name="author" content="Marella Morad">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Manage EOIs</title>
    <!--Add a favicon to the website-->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/enhancements.js"></script>
</head>

<body>
    <?php include('header.inc'); ?>
    <button class="back-to-top hidden"><span class="fa fa-angle-up"></span></button>
    <h1>Display EOI Applications</h1>
    <form method="post" action="displayEOIs.php">
        <p>
            <label for="search-reference-number">Job Reference Number:</label>
            <select name="search-reference-number" id="search-reference-number">
                <option value="">Please Select</option>
                <option value="bdatw">BDATW - Big Data Analyst</option>
                <option value="swetw">SWETW - Software Engineer</option>
            </select>
        </p>
        <p>
            <label for="search-first-name">First Name:</label>
            <input type="text" name="search-first-name" id="search-first-name">
        </p>
        <p>
            <label for="search-last-name">Last Name:</label>
            <input type="text" name="search-last-name" id="search-last-name">
        </p>
        <input type="submit" name="search" value="Search">
    </form>

    <?php
        require_once("settings.php");
        
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

        //Checks if connection is successful
        if (!$conn) {
            //Display an error message
            echo "<p>Database connection failure</p>"; //not in production script
        } else { 
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
                $search_reference_number = isset($_POST["search-reference-number"])
                                         ? $_POST["search-reference-number"]
                                         : "";
                $search_firstname = isset($_POST["search-first-name"])
                                  ? trim(htmlspecialchars($_POST["search-first-name"]))
                                  : "";
                $search_lastname = isset($_POST["search-last-name"])
                                 ? trim(htmlspecialchars($_POST["search-last-name"]))
                                 : "";
            
                $selectedFilters = false;

                $query = "SELECT * FROM EOI";
                $queryCount = "SELECT Count(*) FROM EOI";
                $conditions = array();
                if (!empty($search_reference_number)) {
                    $conditions[] = "JobReferenceNumber = '$search_reference_number'";
                    $selectedFilters = true;
                }

                if (!empty($search_firstname)) {
                    $conditions[] = "FirstName like '%$search_firstname%'";
                    $selectedFilters = true;
                }

                if (!empty($search_lastname)) {
                    $conditions[] = "LastName like '%$search_lastname%'";
                    $selectedFilters = true;
                }

                //if the user has entered filters, then search by filters, otherwise show everything
                if ($selectedFilters) {
                    $query .= " WHERE ";
                    $queryCount .= " WHERE ";
                    $query .= implode(" AND ", $conditions);
                    $queryCount .= implode(" AND ", $conditions);
                }

                $result = mysqli_query($conn, $query);
                $resultCount = mysqli_query($conn, $queryCount);
                $resultCountRow = mysqli_fetch_assoc($resultCount);

                //checks if the execution was successful
                if ($resultCountRow["Count(*)"] == 0) {
                    echo "<p>No results found!</p>";
                } else {
                    // display an operation successful message
                    echo "<p>", $resultCountRow["Count(*)"], " Result/s Found</p>";

                    //Display the retrieved records
                    echo "<table border=\"1\">\n";
                    echo "<tr>\n "
                        ."<th scope=\"col\">Job Reference Number</th>\n "
                        ."<th scope=\"col\">First Name</th>\n "
                        ."<th scope=\"col\">Last Name</th>\n "
                        ."<th scope=\"col\">Date Of Birth</th>\n "
                        ."<th scope=\"col\">Gender</th>\n "
                        ."<th scope=\"col\">Street Address</th>\n "
                        ."<th scope=\"col\">Suburb</th>\n "
                        ."<th scope=\"col\">State</th>\n "
                        ."<th scope=\"col\">Postcode</th>\n "
                        ."<th scope=\"col\">Email Address</th>\n "
                        ."<th scope=\"col\">Mobile Number</th>\n "
                        ."<th scope=\"col\">Skills</th>\n "
                        ."<th scope=\"col\">Other Skills Description</th>\n "
                        ."<th scope=\"col\">Application Status</th>\n "
                        ."</tr>\n ";

                    //retrieve current record pointed by the result pointer
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>\n ";
                        echo "<td>", $row["JobReferenceNumber"],"</td>\n ";
                        echo "<td>", $row["FirstName"],"</td>\n ";
                        echo "<td>", $row["LastName"],"</td>\n ";
                        echo "<td>", $row["DOB"],"</td>\n ";
                        echo "<td>", $row["Gender"],"</td>\n ";
                        echo "<td>", $row["StreetAddress"],"</td>\n ";
                        echo "<td>", $row["Suburb"],"</td>\n ";
                        echo "<td>", $row["State"],"</td>\n ";
                        echo "<td>", $row["Postcode"],"</td>\n ";
                        echo "<td>", $row["EmailAddress"],"</td>\n ";
                        echo "<td>", $row["PhoneNumber"],"</td>\n ";
                        echo "<td>", $row["Skills"],"</td>\n ";
                        echo "<td>", $row["OtherSkills"],"</td>\n ";
                        echo "<td>", $row["Status"],"</td>\n ";
                        echo "</tr>\n ";
                    }
                    echo "</table>\n ";
                } // if successful query operation

                //Frees up the memory, after using the result pointer
                mysqli_free_result($result);
                mysqli_free_result($resultCount);
            }
        }
        //close database connection
        mysqli_close($conn);

        include('footer.inc');
    ?>
</body>