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
    <?php include('header.inc'); include('menu.inc');?>
    <button class="back-to-top hidden"><span class="fa fa-angle-up"></span></button>
    <h1>HR Management Portal</h1>
    <div id="hr-actions">
        <a class="manage-buttons" href="?action=displayEOIs"><span id="display-eois">Display EOI Applications</span></a>
        <a class="manage-buttons" href="?action=deleteEOIs"><span id="delete-eois">Delete EOI Applications</span></a>
        <a class="manage-buttons" href="?action=updateEOIStatus"><span id="update-eois">Update the Status of EOI Applications</span></a>
    </div>
    <?php
        session_start();
        require_once("settings.php");
            
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
        
        //Checks if connection is successful
        if (!$conn) {
            //Display an error message
            echo '<p class="message"><span class="fa fa-times-circle"></span>Database connection failure</p>';
        }

        if (!isset($_SESSION['loggedin'])) {
            header('Location: login.php');
        } else {
            if (isset($_GET['action'])) {
                //Display EOIs
                if ($_GET['action'] == 'displayEOIs') {
                    include('displayEOIs.inc');

                    //Process display EOIs request
                    //Validate the posted reference number
                    if (isset($_POST['action']) && $_POST['action'] == 'displayEOIs') {
                        $search_reference_number = validateRefNum($conn, $_POST['search-reference-number'], false);

                        $search_firstname = isset($_POST["search-first-name"])
                                        ? sanitise_input($_POST["search-first-name"])
                                        : "";
                        $search_lastname = isset($_POST["search-last-name"])
                                        ? sanitise_input($_POST["search-last-name"])
                                        : "";
                    
                        $selectedFilters = false;
                    
                        $display_query = "SELECT * FROM EOI";
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
                            $display_query .= " WHERE ";
                            $display_query .= implode(" AND ", $conditions);
                        }
                    
                        if ($_POST["sort"] != "") {
                            $display_query .= " Order By " . $_POST["sort"];
                        }
                    
                        $display_result = mysqli_query($conn, $display_query);
                        $display_result_count = mysqli_num_rows($display_result);
                    
                        //checks if the execution was successful
                        if ($display_result_count == 0) {
                            echo '<p class="message"><span class="fa fa-check-circle"></span>No results found!</p>';
                        } else {
                            // display an operation successful message
                            echo '<p class="message"><span class="fa fa-check-circle"></span>', $display_result_count, ' Result/s Found</p>';
                    
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
                            while ($row = mysqli_fetch_assoc($display_result)) {
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
                                echo "<td>", $row["Skills"] == '' ? "None Selected" : $row["Skills"],"</td>\n ";
                                echo "<td>", $row["OtherSkills"] == '' ? "N/A" : $row["OtherSkills"],"</td>\n ";
                                echo "<td>", $row["Status"],"</td>\n ";
                                echo "</tr>\n ";
                            }
                            echo "</table>\n ";
                            echo "</div>\n ";
                        } // if successful query operation
                        //Frees up the memory, after using the result pointer
                        mysqli_free_result($display_result);
                    }
                
                //Delete EOIs
                } else if ($_GET['action'] == 'deleteEOIs') {
                    include('deleteEOIs.inc');

                    //Process the delete EOIs request
                    if (isset($_POST['action']) && $_POST['action'] == 'deleteEOIs') {
                        $delete_reference_number = validateRefNum($conn, $_POST["delete-reference-number"], true);
                        if ($delete_reference_number) {
                            $search_ref_query = "SELECT * FROM EOI WHERE JobReferenceNumber = '$delete_reference_number'";
                            
                            $search_ref_result = mysqli_query($conn, $search_ref_query);
                            $search_ref_result_count = mysqli_num_rows($search_ref_result);
    
                            if ($search_ref_result_count == 0) {
                                echo '<p class="message"><span class="fa fa-check-circle"></span>No results found, Nothing will be deleted!</p>';
                            } else {
                                echo '<p class="message"><span class="fa fa-check-circle"></span>', $search_ref_result_count, ' Result/s Found</p>';
                                $delete_query = "DELETE FROM EOI WHERE JobReferenceNumber = '$delete_reference_number'";
                                $delete_result = mysqli_query($conn, $delete_query);
                                
                                if ($delete_result) {
                                    echo '<p class="message"><span class="fa fa-check-circle"></span> All ', $search_ref_result_count, ' Applications have been Deleted.</p>';
                                } else {
                                    echo '<p class="message"><span class="fa fa-times-circle"></span>An Error Occurred While Trying to Delete the Applications.</p>';
                                }
    
                                //Frees up the memory, after using the result pointer
                                mysqli_free_result($search_ref_result);
                            }
                        }
                    }

                //Update EOI Status
                } else if ($_GET['action'] == 'updateEOIStatus') {
                    include('updateEOIStatus.inc');

                    //Process the update EOI status request
                    if (isset($_POST['action']) && $_POST['action'] == 'updateEOIStatus') {
                        $eoi_number = isset($_POST["eoi_number"])
                                    ? sanitise_input($_POST["eoi_number"])
                                    : "";
                        $new_status = isset($_POST["new_status"])
                                    ? $_POST["new_status"]
                                    : "";

                        $selectedFilters = false;

                        if (!empty($eoi_number) && !empty($new_status)) {
                            $search_eoi_query = "SELECT * FROM EOI WHERE EOInumber = '$eoi_number'";

                            $search_eoi_result = mysqli_query($conn, $search_eoi_query);
                            $search_eoi_result_count = mysqli_num_rows($search_eoi_result);

                            //checks if the execution was successful
                            if ($search_eoi_result_count == 0) {
                                echo '<p class="message"><span class="fa fa-exclamation-triangle"></span>No results found, make sure you\'re entering the correct EOI number</p>';
                            } else {
                                $update_query = "UPDATE EOI SET Status = '$new_status' WHERE EOInumber = '$eoi_number'";
                                $update_result = mysqli_query($conn, $update_query);

                                if (!$update_result) {
                                    echo '<p class="message"><span class="fa fa-times-circle"></span>Something went wrong while trying to update the status of EOI with EOI Number = ' . $eoi_number . '</p>';
                                } else {
                                    $row = mysqli_fetch_assoc($search_eoi_result);
                                    echo '<p class="message"><span class="fa fa-check-circle"></span>The Status of EOI with EOI Number =', $eoi_number , ', has been changed from ' , $row["Status"] , ' to ' , $new_status , '</p>';
                                }
                            }

                            //Frees up the memory, after using the result pointers
                            mysqli_free_result($search_eoi_result);
                        } else {
                            echo '<p class="message"><span class="fa fa-times-circle"></span>Make Sure You have filled in both the EOI Number and the New Status!</p>';
                        }
                    }
                }
            }
        }

        // close the database connection
        mysqli_close($conn);

        function validateRefNum($conn, $post_ref_num, $required) {
            if ($required && (!isset($post_ref_num) || trim($post_ref_num) === '')) {
                echo '<p class="message"><span class="fa fa-times-circle"></span>Please Enter a Job Reference Number</p>';
            }
            else if (isset($post_ref_num) && trim($post_ref_num) != '') {
                $ref_pattern = '/^[a-zA-Z0-9]{5}$/';
                if (!preg_match($ref_pattern, $post_ref_num)) {
                    echo '<p class="message"><span class="fa fa-times-circle"></span>The Job Reference Number must be Exactly 5 Alphanumeric Characters' . (!$required ? ' and so it will not be considered in the search' : '') . '</p>';
                } else {
                    $sqlString = "show tables like 'JobReferenceNumbers'";
                    $result = @mysqli_query($conn, $sqlString);
                    
                    //check if the table exists
                    if($result) {
                        // Store the posted reference number
                        $temp_reference_number = strtoupper($post_ref_num);

                        //check if the entered reference number exists
                        $search_query = "SELECT * FROM JobReferenceNumbers WHERE Code = '$temp_reference_number'";
            
                        //add an EOI record to the database - execute the query
                        $search_result = mysqli_query($conn, $search_query);
                        $search_result_count = mysqli_num_rows($search_result);
                        // checks if the execution was successful
                        if($search_result_count == 0) {
                            echo '<p class="message"><span class="fa fa-times-circle"></span>Invalid Job Reference Number' . (!$required ? ' and so it will not be considered in the search' : '') . '</p>';
                        } else { //if successful
                            // Store the posted reference number
                            return sanitise_input($post_ref_num);
                        }
                    }

                    //Frees up the memory, after using the result pointer
                    mysqli_free_result($result);
                }
            } else {
                return "";
            }
        }

        function sanitise_input($data) {
            $data = trim($data);
            $data = stripslashes($data) ;
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <?php include('footer.inc'); ?>
</body>