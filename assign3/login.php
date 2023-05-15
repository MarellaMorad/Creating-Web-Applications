<?php
    session_start();
    // Check if the user has already failed login attempts
    if (isset($_SESSION['failed_attempts'])) {
        $failed_attempts = $_SESSION['failed_attempts'];
    } else {
        $failed_attempts = 0;
    }

    if (isset($_SESSION['last_failed_attempt'])) {
        $now = time();
        $last_failed_attempt = $_SESSION['last_failed_attempt'];
        $time_diff = $now - $last_failed_attempt;
    
        // If the user has failed 3 or more times and it's been less than 30 minutes, deny access
        if ($failed_attempts >= 3 && $time_diff <= 1800) {
            exit('Access disabled for 30 minutes after 3 unsuccessful login attempts.');
        }
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
    <?php include('header.inc'); include('menu.inc');?>
    <button class="back-to-top hidden"><span class="fa fa-angle-up"></span></button>
    <h1>HR Manager Login</h1>
    <?php
        if (isset($_SESSION["justsignedup"])) {
            echo '<p class="message"><span class="fa fa-check-circle"></span>You have Successfully Signed Up, Please enter your details to Login and start using the HR Portal</p>';
        }
    ?>
    <div class="login-forms form-container">
        <form method="post" action="login.php" id="log-in-form">
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
                <input type="submit" name="log-in" value="LOGIN">
            </div>
            <p>Don't have an account?&nbsp;<a href="manage.php">Sign Up Now!</a></p>
        </form>
    </div>
    <?php
        if (!isset($_SESSION['loggedin'])) {
            require_once("settings.php");
            $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
            if (!$conn) {
                //Display an error message
                echo '<p class="message"><span class="fa fa-times-circle"></span>Database connection failure</p>';
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log-in'])) {
                    //Manager logging in
                    $login_username = $_POST["manager-username"];
                    $login_password = $_POST["manager-password"];

                    $login_query = "SELECT * FROM Manager WHERE Username = '$login_username'";
                    $login_result = mysqli_query($conn, $login_query);
                    $login_result_count = mysqli_num_rows($login_result);

                    if ($login_result_count == 0) {
                        echo '<p class="message"><span class="fa fa-times-circle"></span>Account not Found</p>';
                    } else {
                        //Username is found, check if password is correct
                        $pass_query = "SELECT * FROM Manager WHERE Username = '$login_username' AND Pass = '$login_password'";
                        $pass_result = mysqli_query($conn, $pass_query);
                        $pass_result_count = mysqli_num_rows($pass_result);
                        if ($pass_result_count == 0) {
                            $failed_attempts++;
                            $_SESSION['failed_attempts'] = $failed_attempts;
                            $_SESSION['last_failed_attempt'] = time();
                            if ($failed_attempts >= 3) {
                                echo '<p class="message"><span class="fa fa-times-circle"></span>Access will be disabled for 30 mins after 3 unsuccessful login attempts.</p>';
                            } else {
                                echo '<p class="message"><span class="fa fa-times-circle"></span>Incorrect Password, you have ' . (3 - $failed_attempts) . ' more attempts to login, then your access will be disabled for 30 mins</p>';
                            }
                        } else {
                            $_SESSION['loggedin'] = "YES";
                            unset($_SESSION['failed_attempts']);
                            unset($_SESSION['last_failed_attempt']);
                            header('Location: manage.php');
                            exit;
                        }
                    }

                    //free all result pointers
                    mysqli_free_result($login_result);
                    mysqli_free_result($pass_result);
                }
            }
        } else {
            header('Location: manage.php');
            exit;
        }
    ?>
    <?php include('footer.inc'); ?>
</body>