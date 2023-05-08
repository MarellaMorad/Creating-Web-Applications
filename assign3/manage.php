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
    <?php
        session_start();

        if (!isset($_SESSION['loggedin'])) {
            include('sign-up.inc');

            require_once("settings.php");
            $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
            if (!$conn) {
                //Display an error message
                echo '<p class="message"><span class="fa fa-times-circle"></span>Database connection failure</p>';
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sign-up'])) {
                    //Manager signing up
                    $signup_username = $_POST["manager-username"];
                    $signup_password = $_POST["manager-password"];

                    $query = "INSERT INTO Manager (Username, Pass) Values ('$signup_username', '$signup_password')";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        echo '<p class="message"><span class="fa fa-times-circle"></span>An Error Occurred While trying to Add the Manager</p>';
                    } else {
                        $_SESSION["justsignedup"] = "Yes";
                        header('Location: login.php');
                        exit;
                    }
                }
            }
        } else {
            include('manager_options.inc');
        }
    ?>
    <?php include('footer.inc'); ?>
</body>