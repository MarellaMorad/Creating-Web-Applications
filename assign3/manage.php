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

                    $query = "SELECT Count(*) FROM Manager WHERE Username = '$signup_username'";
                    $result = mysqli_query($conn, $query);
                    $resultRow = mysqli_fetch_assoc($result);

                    if ($resultRow["Count(*)"] == 0) {
                        $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[a-zA-Z\d!@#$%^&*]{8,}$/';

                        if (!preg_match($password_pattern, $signup_password)) {
                            echo '<p class="message"><span class="fa fa-times-circle"></span>The Password you entered is too weak, make sure your password meets our policy:</p>';
                            echo '<p>Your Password Must Be:</p>
                            <ul>
                                    <li>At least 8 characters long</li>
                                    <li>Contains at least one uppercase letter (A-Z)</li>
                                    <li>Contains at least one lowercase letter (a-z)</li>
                                    <li>Contains at least one digit (0-9)</li>
                                    <li>Contains at least one special character (e.g. !,@,#,$,%,&,*)</li>
                            </ul>';
                        } else {
                            $insert_query = "INSERT INTO Manager (Username, Pass) Values ('$signup_username', '$signup_password')";
                            $insert_result = mysqli_query($conn, $insert_query);
        
                            if (!$insert_result) {
                                echo '<p class="message"><span class="fa fa-times-circle"></span>An Error Occurred While trying to Add the Manager</p>';
                            } else {
                                $_SESSION["justsignedup"] = "Yes";
                                header('Location: login.php');
                                exit;
                            }
                        }
                    } else {
                        echo '<p class="message"><span class="fa fa-times-circle"></span>This Username Already exists, please choose a new one</p>';
                    }
                }
            }
        } else {
            include('manager_options.inc');
        }
    ?>
    <?php include('footer.inc'); ?>
</body>