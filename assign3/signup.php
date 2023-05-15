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
    <h1>HR Manager Registration</h1>
    <div class="login-forms form-container">
        <form method="post" action="signup.php" id="sign-up-form">
            <p>
                <label class="required" for="manager-username">Username:</label>
                <input type="text" name="manager-username" id="manager-username" required>
            </p>
            <p class="password-container">
                <label class="required" for="manager-password">Password:</label>
                <input type="password" name="manager-password" id="manager-password" required>
                <span class="toggle-password fa fa-eye"></span>
            </p>
            <div class="login-buttons">
                <input type="submit" name="sign-up" value="SIGN UP">
            </div>
            <p>Already a user?&nbsp;<a href="login.php">LOGIN</a></p>
        </form>
    </div>
    <?php
        session_start();
        if (!isset($_SESSION['loggedin'])) {
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

                    $signup_query = "SELECT * FROM Manager WHERE Username = '$signup_username'";
                    $signup_result = mysqli_query($conn, $signup_query);
                    $signup_result_count = mysqli_num_rows($signup_result);

                    if ($signup_result_count == 0) {
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

                    //Frees up the memory, after using the result pointers
                    mysqli_free_result($signup_result);
                    mysqli_free_result($insert_result);
                }
            }
        } else {
            header('Location: manage.php');
            exit;
        }
    ?>
    <?php include('footer.inc'); ?>
</body>