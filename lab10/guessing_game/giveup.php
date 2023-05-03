<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Creating a simple “Guessing Ga me”">
    <meta name="keywords" content="PHP, DB, MySQL">
    <meta name="author" content="Marella Morad">
    <title>Guessing Game</title>
</head>

<body>
    <h1>Guessing Game</h1>
    <?php
        $hidden_num = $_SESSION['random_number'];
        echo "The hidden number was: " . $hidden_num;
    ?>

    <p><a href="startover.php">Start Over</a></p>

</body>

</html>