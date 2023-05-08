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
    <form class="form-container manager-actions" method="post" action="deleteEOIs.php">
        <h2>Delete EOI Applications</h2>
        <p class="message"><span class="fa fa-exclamation-triangle"></span>Warning: Use this function CAREFULLY as once you click on the delete button, ALL records that match the filters will be DELETED FOREVER!</p>
        <p>
            <label class="required" for="delete-reference-number">Job Reference Number:</label>
            <select name="delete-reference-number" id="delete-reference-number" required>
                <option value="">Please Select</option>
                <option value="bdatw">BDATW - Big Data Analyst</option>
                <option value="swetw">SWETW - Software Engineer</option>
            </select>
        </p>
        <div class="buttons">
            <input type="submit" name="delete" value="Delete">
        </div>
        <?php 
            require_once("settings.php");
            
            $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
            
            //Checks if connection is successful
            if (!$conn) {
                //Display an error message
                echo '<p class="message"><span class="fa fa-times-circle"></span>Database connection failure</p>';
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                    $delete_reference_number = $_POST["delete-reference-number"];

                    $query = "SELECT * FROM EOI WHERE JobReferenceNumber = '$delete_reference_number'";
                    $queryCount = "SELECT Count(*) FROM EOI WHERE JobReferenceNumber = '$delete_reference_number'";
                    
                    $result = mysqli_query($conn, $query);
                    $resultCount = mysqli_query($conn, $queryCount);
                    $resultCountRow = mysqli_fetch_assoc($resultCount);
        
                    if ($resultCountRow["Count(*)"] == 0) {
                        echo '<p class="message"><span class="fa fa-check-circle"></span>No results found!</p>';
                    } else {
                        echo '<p class="message"><span class="fa fa-check-circle"></span>', $resultCountRow["Count(*)"], ' Result/s Found</p>';
                        $delete_query = "DELETE FROM EOI WHERE JobReferenceNumber = '$delete_reference_number'";
                        $delete_result = mysqli_query($conn, $delete_query);
                        
                        if ($delete_result) {
                            echo '<p class="message"><span class="fa fa-check-circle"></span> All ', $resultCountRow["Count(*)"], ' Applications have been Deleted.</p>';
                        } else {
                            echo '<p class="message"><span class="fa fa-times-circle"></span>An Error Occurred While Trying to Delete the Applications.</p>';
                        }
        
                        //Frees up the memory, after using the result and resultCount pointers
                        mysqli_free_result($result);
                        mysqli_free_result($resultCount);
                    }
                }
            }
            //close database connection
            mysqli_close($conn);        
        ?>
    </form>
    <?php include('footer.inc'); ?>
</body>