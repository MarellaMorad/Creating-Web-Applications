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
        session_start();

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

                $query = "SELECT Count(*) FROM Manager WHERE Username = '$login_username' AND Pass = '$login_password'";
                $result = mysqli_query($conn, $query);
                $resultRow = mysqli_fetch_assoc($result);

                if ($resultRow["Count(*)"] == 0) {
                    echo '<p class="message"><span class="fa fa-times-circle"></span>Account not Found/Incorrect Login Details</p>';
                } else {
                    $_SESSION['loggedin'] = "YES";
                    header('Location: manage.php');
                    exit;
                }
            }
        }
    ?>
    <?php include('footer.inc'); ?>
</body>