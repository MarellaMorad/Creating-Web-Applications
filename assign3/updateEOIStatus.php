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
    <?php include('header.inc'); include('manager_options.inc')?>
    <button class="back-to-top hidden"><span class="fa fa-angle-up"></span></button>
    <form class="form-container manager-actions" method="post" action="updateEOIStatus.php">
        <h2>Change the Status of EOI Applications</h2>
        <p>
            <label class="required" for="eoi_number">EOI Number:</label>
            <input type="text" name="eoi_number" id="eoi_number" required placeholder="Enter the unique EOI number for the Application you wish to Update">
        </p>

        <p>
            <label class="required" for="new_status">New Status:</label>
            <select name="new_status" id="new_status" required>
                <option value="">Please Select</option>
                <option value="New">New</option>
                <option value="Current">Current</option>
                <option value="Final">Final</option>
            </select>
        </p>
        <div class="buttons">
            <input type="submit" name="update-status" value="Update Status">
        </div>
        <?php
            require_once("settings.php");
            $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
            //Checks if connection is successful
            if (!$conn) {
                //Display an error message
                echo '<p class="message"><span class="fa fa-times-circle"></span>Database connection failure</p>';
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-status'])) {
                    $eoi_number = trim(htmlspecialchars($_POST["eoi_number"]));
                    $new_status = $_POST["new_status"];

                    $selectedFilters = false;

                    $query = "SELECT * FROM EOI WHERE EOInumber = '$eoi_number'";
                    $queryCount = "SELECT Count(*) FROM EOI WHERE EOInumber = '$eoi_number'";

                    $result = mysqli_query($conn, $query);
                    $resultCount = mysqli_query($conn, $queryCount);
                    $resultCountRow = mysqli_fetch_assoc($resultCount);

                    //checks if the execution was successful
                    if ($resultCountRow["Count(*)"] == 0) {
                        echo '<p class="message"><span class="fa fa-exclamation-triangle"></span>No results found, make sure you\'re entering the correct EOI number</p>';
                    } else {
                        $update_query = "UPDATE EOI SET Status = '$new_status' WHERE EOInumber = '$eoi_number'";
                        $update_result = mysqli_query($conn, $update_query);

                        if (!$update_result) {
                            echo '<p class="message"><span class="fa fa-times-circle"></span>Something went wrong while trying to update the status of EOI with EOI Number = ' . $eoi_number . '</p>';
                        } else {
                            $row = mysqli_fetch_assoc($result);
                            echo '<p class="message"><span class="fa fa-check-circle"></span>The Status of EOI with EOI Number =', $eoi_number , ', has been changed from ' , $row["Status"] , ' to ' , $new_status , '</p>';
                        }
                    }
                }
                
            }
        ?>
    </form>
    <?php include('footer.inc'); ?>
</body>