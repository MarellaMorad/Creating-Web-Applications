<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Creating Web Applications">
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP, SQL">
    <meta name="author" content="Marella Morad">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Message from TechWave</title>
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

        if (isset($_SESSION['direct-access'])) {
            echo '<p class="message"><span class="fa fa-times-circle"></span>Direct Access to processEOI.php is not permitted, please submit an application and we\'ll get back to you as soon as possible</p>';
        } else if (isset($_SESSION['eoi_number'])) {
            echo "<p>Thank you for your expression of interest. Your EOInumber is: " . $_SESSION['eoi_number'] ."</p>";
            echo "<p>Feel Free to continue browsing our site, you can also apply for other available positions!</p>";
        }

        unset($_SESSION['direct-access']);
    ?>
    <?php include('footer.inc'); ?>
</body>