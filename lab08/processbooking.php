<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="PHP Form Validation">
    <meta name="keywords" content="PHP, Validation">
    <meta name="author" content="Marella Morad">
    <title>Booking Confirmation</title>
</head>

<body>
    <h1>Rohirrim Tour Booking Confirmation</h1>
    <?php
        function sanitise_input($data) {
            $data = trim($data);
            $data = stripslashes($data) ;
            $data = htmlspecialchars($data);
            return $data;
        }

        //read input into corresponding variables
        if (isset($_POST["firstname"])) {
            $firstname = $_POST["firstname"];
        } else {
            header("location: register.html");
        }

        if (isset ($_POST["lastname"])) {
            $lastname = $_POST["lastname"];
        }

        if (isset ($_POST["species"])) {
            $species = $_POST["species"];
        } else {
            $species = "Unknown Species";
        }

        $tours = [];
        if (isset($_POST["1day"])) array_push($tours, "One-day tour");
        if (isset($_POST["4day"])) array_push($tours, "Four-day tour");
        if (isset($_POST["10day"])) array_push($tours, "Ten-day tour");

        if (count($tours) > 1) {
            $last_tour = array_pop($tours);
            $tour = implode(", ", $tours) . " and " . $last_tour;
        } 
        else {
            $tour = implode(", ", $tours);
        }

        if (isset ($_POST["age"])) {
            $age = $_POST["age"];
        }

        if (isset ($_POST["food"])) {
            $food = $_POST["food"];
        }
        
        if (isset ($_POST["partySize"])) {
            $partySize = $_POST["partySize"];
        }

        //sanitise all inputs
        $firstname = sanitise_input($firstname);
        $lastname = sanitise_input($lastname);
        $species = sanitise_input($species);
        $age = sanitise_input($age);
        $food = sanitise_input($food);
        $partySize = sanitise_input($partySize);

        //validate inputs
        $errMsg = "";

        if ($firstname == "") {
            $errMsg .= "<p>You must enter your first name.<p>";
        } else if (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
            $errMsg .= "<p>Only alpha letters allowed in your first name.</p>";
        }

        if ($lastname == "") {
            $errMsg .= "<p>You must enter your last name.<p>";
        } else if (!preg_match("/^[A-Za-z\-]+$/", @$lastname)) {
            $errMsg .= "<p>Only alpha letters or hyphen are allowed in your last name.</p>";
        }

        if ($species == "Unknown Species") {
            $errMsg .= "<p>You must select your species.<p>";
        }

        if ($age == "") {
            $errMsg .= "<p>You must enter your age.<p>";
        } else if (!is_numeric($age)) {
            $errMsg .= "<p>You age must be a number<p>";
        } else if ($age > 10000 || $age < 10) {
            $errMsg .= "<p>You must be between 10 and 10,000 years old.<p>";
        }

        if (count($tours) == 0) {
            $errMsg .= "<p>You must select at least one tour.<p>";
        }

        if ($food == "none") {
            $errMsg .= "<p>You must select a meal preference.<p>";
        }

        if ($partySize == "") {
            $errMsg .= "<p>You must enter the number of travelers.<p>";
        } else if (!is_numeric($partySize)) {
            $errMsg .= "<p>The number of travelers must be a Number!<p>";
        }

        if ($errMsg != "") {
            echo "<p>$errMsg</p>";
        } else {
            echo "<p> Welcome $firstname $lastname !<br>
                  You are now booked on the $tour.<br>
                  Species: $species.<br>
                  Age: $age.<br>
                  Meal Preference: $food.<br>
                  Number of travelers: $partySize.<br>";
        }
    ?>
</body>

</html>