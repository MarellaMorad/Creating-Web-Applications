<?php
    session_start();
    // Check if the session variable already exists
    if (!isset($_SESSION['random_number'])) {
        // Set the session variable
        $_SESSION['random_number'] = rand(1, 100);
        $_SESSION["guess_count"] = 0;
    }
?>

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
    <p>Enter a number between 1 and 100, then press the Guess button.</p>
    <form method="post">
        <input type="text" name="guess" id="guess">
        <input type="submit" value="Guess">
    </form>
    <?php 
        if (isset($_GET['giveup'])) {
            // Give up and show the hidden number
        echo "The hidden number was: " . $_SESSION['random_number'];
        } else {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get the user's guess
                if (isset($_POST['guess'])) {
                    $guess = $_POST['guess'];
                    // Check if the guess is in range
                    if (!is_numeric($guess)) {
                        // Invalid guess
                        echo "<p>Your guess is not a number. Please enter a number between 1 and 100.</p>";
                    } elseif ($guess < 1 || $guess > 100){
                        // Invalid guess
                        echo "<p>Your guess is not in range. Please enter a number between 1 and 100.</p>";
                    } else {
                        // Valid guess

                        // Increment the number of guesses
                        $_SESSION['guess_count']++;

                        // Check if the guess is correct
                        if ($guess == $_SESSION['random_number']) {
                            // Correct guess
                            echo "<p>Congratulations! You guessed the correct number!</p>";
                            unset($_SESSION['random_number']);
                            unset($_SESSION['guess_count']);
                        } else {
                            // Incorrect guess
                            if ($guess > $_SESSION['random_number']) {
                            echo "<p>Your guess is higher than the generated number</p>";
                            } else {
                            echo "<p>Your guess is lower than the generated number</p>";
                            }
                        }
                    }
                }
            }
        }

        if (isset($_SESSION["guess_count"]) && $_SESSION["guess_count"] > 0) {
            echo "<p>Number of guesses: ", $_SESSION["guess_count"];
        }
    ?>
    <p><a href="guessinggame.php?giveup=yes">Give Up</a></p>
    <p><a href="startover.php">Start Over</a></p>

</body>

</html>