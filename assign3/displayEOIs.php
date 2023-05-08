<?php
    session_start();
    if (!isset($_SESSION["loggedin"])) {
        header('Location: manage.php');
        exit;
    }
?>

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
    <?php include('header.inc'); include('menu.inc'); include('manager_options.inc')?>
    <button class="back-to-top hidden"><span class="fa fa-angle-up"></span></button>
    <form class="form-container manager-actions" method="post" action="displayEOIs.php">
        <h2>Display EOI Applications</h2>
        <p class="message"><span class="fa fa-info-circle"></span>If you want to display all EOIs that are present in the database, leave all the filters unset.</p>
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
        <p>
            <label for="sort">Sort Results By:</label>
            <select name="sort" id="sort">
                <option value="">Please Select</option>
                <option value="JobReferenceNumber">Job Reference Number</option>
                <option value="FirstName">Firstname</option>
                <option value="LastName">Lastname</option>
            </select>
        </p>
        <div class="buttons">
            <input type="submit" name="search" value="Search">
        </div>
        <?php
            require_once("settings.php");
            
            $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

            //Checks if connection is successful
            if (!$conn) {
                //Display an error message
                echo '<p class="message"><span class="fa fa-times-circle"></span>Database connection failure</p>'; //not in production script
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

                    if ($_POST["sort"] != "") {
                        $query .= " Order By " . $_POST["sort"];
                    }

                    $result = mysqli_query($conn, $query);
                    $resultCount = mysqli_query($conn, $queryCount);
                    $resultCountRow = mysqli_fetch_assoc($resultCount);

                    //checks if the execution was successful
                    if ($resultCountRow["Count(*)"] == 0) {
                        echo '<p class="message"><span class="fa fa-check-circle"></span>No results found!</p>';
                    } else {
                        // display an operation successful message
                        echo '<p class="message"><span class="fa fa-check-circle"></span>', $resultCountRow["Count(*)"], ' Result/s Found</p>';

                        //Display the retrieved records
                        echo "<div class=\"table-wrapper\">\n";
                        echo "<table>\n";
                        echo "<tr>\n "
                            ."<th scope=\"col\">EOI Number</th>\n "
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
                            echo "<td>", $row["EOInumber"],"</td>\n ";
                            echo "<td>", strtoupper($row["JobReferenceNumber"]),"</td>\n ";
                            echo "<td>", $row["FirstName"],"</td>\n ";
                            echo "<td>", $row["LastName"],"</td>\n ";
                            echo "<td>", $row["DOB"],"</td>\n ";
                            echo "<td>", ucfirst($row["Gender"]),"</td>\n ";
                            echo "<td>", $row["StreetAddress"],"</td>\n ";
                            echo "<td>", $row["Suburb"],"</td>\n ";
                            echo "<td>", strtoupper($row["State"]),"</td>\n ";
                            echo "<td>", $row["Postcode"],"</td>\n ";
                            echo "<td>", $row["EmailAddress"],"</td>\n ";
                            echo "<td>", $row["PhoneNumber"],"</td>\n ";
                            echo "<td>", $row["Skills"],"</td>\n ";
                            echo "<td>", $row["OtherSkills"] == '' ? "N/A" : $row["OtherSkills"],"</td>\n ";
                            echo "<td>", $row["Status"],"</td>\n ";
                            echo "</tr>\n ";
                        }
                        echo "</table>\n ";
                        echo "</div>\n ";
                    } // if successful query operation

                    //Frees up the memory, after using the result pointer
                    mysqli_free_result($result);
                    mysqli_free_result($resultCount);
                }
            }
            //close database connection
            mysqli_close($conn);
        ?>
    </form>
    <?php include('footer.inc'); ?>
</body>