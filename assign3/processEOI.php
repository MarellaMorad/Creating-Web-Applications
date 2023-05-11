<?php
    //Start the session
    //use the session_start() function to start a session. This will allow you to store the errors in the session variable,
    //and then retrieve them from the session variable in the apply.php file.
    session_start();
    require_once("settings.php");

    $errors = array();

    //don't allow direct access to this page (redirect if directly accessed)
    if (!isset($_POST['reference-number'])) {
        $_SESSION["direct-access"] = "YES";
        header('Location: apply.php');
    }

    //server-side validation
    //exactly 5 alphanumeric regex pattern
    $ref_pattern = '/^[a-zA-Z0-9]{5}$/';
    if (!isset($_POST['reference-number']) || trim($_POST['reference-number']) === ''){
        $errors['reference-number'] = 'Please enter your Job Reference Number.';
    } else {
        if (!preg_match($ref_pattern, $_POST['reference-number'])) {
            $errors['reference-number'] = 'The Job Reference Number must be Exactly 5 Alphanumeric Characters';
        } else {
            //get reference number from db
            $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
    
            if(!$conn) {
                //Display an error message
                echo '<p class="message"><span class="fa fa-times-circle"></span>Database connection failure</p>'; //not in production script
            } else {
                //Successful connection
                $sql_table = 'JobReferenceNumbers';
                $field_def = 'Id INT AUTO_INCREMENT PRIMARY KEY, 
                              Code VARCHAR(5), 
                              Description VARCHAR(255)';
    
                //check if the table doesn't exist, create table
                $sqlString = "show tables like '$sql_table'";  // another alternative is to just use 'create table if not exists ...'
                $result1 = @mysqli_query($conn, $sqlString);

                // checks if any tables of this name
                if(mysqli_num_rows($result1) === 0) {
                    //Table does not exist - create table
                    echo '<p class="message"><span class="fa fa-exclamation-triangle"></span>Table does not exist, creating table...</p>';
                    $sqlString = "create table " . $sql_table . "(" . $field_def . ")";
                    $result2 = @mysqli_query($conn, $sqlString);
                    // checks if the table was created
                    if($result2 === false) {
                        echo '<p class="message"><span class="fa fa-times-circle"></span>Unable to create Table ' , $sql_table , '!</p>';
                    } else {
                        echo '<p class="message"><span class="fa fa-check-circle"></span>Table Created Successfully!</p>';
    
                        // Insert the active reference numbers in the table
                        $query = "INSERT INTO $sql_table"
                        ."(Code, Description)" ." VALUES "
                        ."('SWETW', 'Software Engineer'),
                          ('BDATW', 'Big Data Analyst')";
    
                        $result3 = mysqli_query($conn, $query);
    
                        if (!$result3) {
                            echo '<p class="message"><span class="fa fa-times-circle"></span>Something is wrong with ',	$query, '</p>';
                        } else {
                            echo '<p class="message"><span class="fa fa-check-circle"></span>Active Records Added to the Table!</p>';
                        }
                    }
                } else {
                    echo '<p class="message"><span class="fa fa-check-circle"></span>Table Already Exists!</p>';
                }
    
                // Store the posted reference number
                $temp_reference_number = strtoupper($_POST['reference-number']);

                //check if the entered reference number exists
                $search_query = "SELECT Count(*) FROM JobReferenceNumbers WHERE Code = '$temp_reference_number'";
    
                //add an EOI record to the database - execute the query
                $search_result = mysqli_query($conn, $search_query);
                $search_result_row = mysqli_fetch_assoc($search_result);
                // checks if the execution was successful
                if($search_result_row["Count(*)"] == 0) {
                    echo '<p class="message"><span class="fa fa-times-circle"></span>Not Found!</p>';
                    $errors['reference-number'] = 'Invalid Job Reference Number!';
                } else { //if successful
                    echo '<p class="message"><span class="fa fa-check-circle"></span>Found!</p>';
                    // Store the posted reference number
                    $reference_number = $_POST['reference-number'];
                }
            }
        }
    }
    
    // alpha regex pattern
    $alpha_pattern = '/^[A-Za-z]+$/';

    //validate firstname - required + max 20 alpha
    if (!isset($_POST['first-name']) || trim($_POST['first-name']) === '') {
        $errors['firstname'] = 'Please enter your Firstname.';
    } elseif (!preg_match($alpha_pattern, $_POST['first-name'])) {
        $errors['firstname'] = 'You can only use alphabetical characters';
    } elseif (strlen($_POST['first-name']) > 20) {
        $errors['firstname'] = 'You have reached the maximum number of characters - max 20 characters';
    } else {
        $firstname = $_POST['first-name'];
    }

    //validate lastname - required + max 20 alpha
    if (!isset($_POST['last-name']) || trim($_POST['last-name']) === '') {
        $errors['lastname'] ='Please enter your Lastname.';
    } elseif (!preg_match($alpha_pattern, $_POST['last-name'])) {
        $errors['lastname'] = 'You can only use alphabetical characters';
    } elseif (strlen($_POST['last-name']) > 20) {
        $errors['lastname'] = 'You have reached the maximum number of characters - max 20 characters';
    } else {
        $lastname = $_POST['last-name'];
    }

    // date regex pattern
    $date_pattern = '/^(0?[1-9]|[1-2][0-9]|3[0-1])\/(0?[1-9]|1[0-2])\/([0-9]{4})$/';

    //validate date of birth
    if (!isset($_POST['dob']) || trim($_POST['dob']) === '') {
        $errors['dob'] = 'Please enter your Date of Birth.';
    } elseif (!preg_match($date_pattern, $_POST['dob'])) {
        $errors['dob'] = 'Please Enter a valid Date follow this pattern dd/mm/yyyy';
    } else {
        //The date matches the required pattern, check for age
        $dobPost = $_POST['dob'];
        // Split the date of birth input value by the forward slash delimiter to create an array of day, month, and year.
        $dobInput = explode('/', $dobPost);
        // Create a new DateTime object using the year, month, and day from the input value.
        $dobDate = new DateTime("$dobInput[2]-$dobInput[1]-$dobInput[0]");
        // Create a new DateTime object with the current date.
        $today = new DateTime();
        // Calculate the age using the date_diff() function.
        $interval = $today->diff($dobDate);
        $age = $interval->y;

        // Validate if the age is between 15 and 80
        if ($age < 15 || $age > 80) {
            $errors['dob'] = 'Applicants must be between 15 and 80 years old at the time they fill in the form';
        } else {
            $dob = $_POST['dob']; //valid
        }
    }

    if (!isset($_POST['gender']) || trim($_POST['gender']) === '') {
        $errors['gender'] = 'Please select your Gender.';
    } else {
        $gender = $_POST['gender'];
    }

    if (!isset($_POST['street']) || trim($_POST['street']) === '') {
        $errors['street'] = 'Please fill in your Street Address.';
    } elseif (strlen($_POST['street']) > 40) {
        $errors['street'] = 'You have reached the maximum number of character - max 40 characters';
    } else {
        $street = $_POST['street'];
    }

    if (!isset($_POST['suburb']) || trim($_POST['suburb']) === '') {
        $errors['suburb'] = 'Please fill in your Suburb/town.';
    } elseif (strlen($_POST['suburb']) > 40) {
        $errors['suburb'] = 'You have reached the maximum number of character - max 40 characters';
    } else {
        $suburb = $_POST['suburb'];
    }

    if (!isset($_POST['state']) || trim($_POST['state']) === '') {
        $errors['state'] = 'Please select your State.';
    } else {
        $state = $_POST['state'];
    }

    //postcode regex pattern
    $postcode_pattern = '/^\d{4}$/';
    if (!isset($_POST['postcode']) || trim($_POST['postcode']) === '') {
        $errors['postcode'] = 'Please fill in your Postcode.';
    } elseif (!preg_match($postcode_pattern, $_POST['postcode'])) {
        $errors['postcode'] = 'The Postcode you entered is invalid - postcodes should be exactly 4 digits.';
    } else {
        $postcode = $_POST['postcode'];
    }

    //validate postcode and state pair
    if (isset($state) && isset($postcode)) {
        $statePrefix = [
            "vic" => [3, 8],
            "nsw" => [1, 2],
            "qld" => [4, 9],
            "nt" => [0],
            "wa" => [6],
            "sa" => [5],
            "tas" => [7],
            "act" => [0]
        ];

        $prefix = $statePrefix[$state];

        // Check if the postcode starts with a valid prefix for the selected state
        $isValidPrefix = false;
        foreach ($prefix as $p) {
            if (strpos($postcode, (string)$p) === 0) {
                $isValidPrefix = true;
                break;
            }
        }

        if (!$isValidPrefix) {
            // If the postcode is invalid, display an error message and return false to indicate validation failure.
            $errors['postcode'] = 'Please enter a valid postcode - ' . strtoupper($state) . ' postcodes start with ' . implode(' or ', $prefix) . '.';
        } else {
            $postcode = $_POST['postcode'];
        }
    }

    //email regex pattern
    $email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    if (!isset($_POST['email']) || trim($_POST['email']) === '') {
        $errors['email'] = 'Please fill in your Email Address.';
    } elseif (!preg_match($email_pattern, $_POST['email'])) {
        $errors['email'] = 'Please enter a valid Email Address - for example: JohnSmith@gmail.com';
    } else {
        $email = $_POST['email'];
    }

    //mobile regex pattern
    $mobile_pattern = '/^[0-9 ]{8,12}$/';

    if (!isset($_POST['mobile']) || trim($_POST['mobile']) === '') {
        $errors['mobile'] = 'Please fill in your Mobile Number.';
    } elseif (!preg_match($mobile_pattern, $_POST['mobile'])) {
        $errors['mobile'] = '8 to 12 digits, or spaces';
    } else {
        $mobile = $_POST['mobile'];
    }

    $skills = [];
    if (isset($_POST['skills']) && count($_POST['skills']) != 0) {
        $skills= $_POST['skills'];
    }

    $combinedSkills = implode(', ', $skills); //combine in a comma separated string
    
    if (strpos($combinedSkills, 'other-skills') && (!isset($_POST['other-skills-desc']) || trim($_POST['other-skills-desc']) === '')) {
        $errors['other-skills-desc'] = "Please enter a short description of your Other Skills.";
    } else {
        $other_skills_desc= $_POST['other-skills-desc'];
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: apply.php');
        exit;
    } 
    // if the all data is valid
    else {
        //sanitize data to remove leading and trailing spaces, backslashes and HTML control characters
        $reference_number = sanitise_input($reference_number);
        $firstname = sanitise_input($firstname);
        $lastname = sanitise_input($lastname);
        $dob = sanitise_input($dob);
        $street = sanitise_input($street);
        $suburb = sanitise_input($suburb);
        $postcode = sanitise_input($postcode);
        $email = sanitise_input($email);
        $mobile = sanitise_input($mobile);
        $other_skills_desc = sanitise_input($other_skills_desc);

        if (!$conn) {
            echo '<p class="message"><span class="fa fa-times-circle"></span>Database connection failure</p>';
        } else {
            $sql_table = 'EOI';
            $field_def = 'EOInumber INT AUTO_INCREMENT PRIMARY KEY, 
                          JobReferenceNumber VARCHAR(5), 
                          FirstName VARCHAR(20), 
                          LastName VARCHAR(20), 
                          DOB VARCHAR(10),
                          Gender VARCHAR(10),
                          StreetAddress VARCHAR(40), 
                          Suburb VARCHAR(40), 
                          State VARCHAR(3), 
                          Postcode VARCHAR(4), 
                          EmailAddress VARCHAR(255), 
                          PhoneNumber VARCHAR(12), 
                          Skills VARCHAR(255), 
                          OtherSkills VARCHAR(255), 
                          Status VARCHAR(10) DEFAULT "New"';

            //check if the table doesn't exist, create table
            $sqlString = "show tables like '$sql_table'";  // another alternative is to just use 'create table if not exists ...'
            $result1 = @mysqli_query($conn, $sqlString);

            // checks if any tables of this name
            if(mysqli_num_rows($result1) === 0) {
                //Table does not exist - create table
                $sqlString = "create table " . $sql_table . "(" . $field_def . ")";
                $result2 = @mysqli_query($conn, $sqlString);
                // checks if the table was created
                if($result2 === false) {
                    echo '<p class="message"><span class="fa fa-times-circle"></span>Unable to create Table ' , $sql_table , '!</p>';
                }
            }

            // Set up the SQL command to add the data into the table
            $query = "INSERT INTO $sql_table"
                    ."(JobReferenceNumber, FirstName, LastName, DOB, Gender, StreetAddress, Suburb, State, Postcode, EmailAddress, PhoneNumber, Skills, OtherSkills)"
                    ." VALUES "
                    ."('$reference_number', '$firstname', '$lastname', '$dob', '$gender', '$street', '$suburb', '$state', '$postcode', '$email', '$mobile', '$combinedSkills', '$other_skills_desc')";
            
            //add an EOI record to the database - execute the query
            $result = mysqli_query($conn, $query);

            // checks if the execution was successful
            if(!$result) {
                echo '<p class="message"><span class="fa fa-times-circle"></span>Something is wrong with ',	$query, '</p>';
            } else {
                //if successful, display a confirmation message with the unique EOInumber from db
                $eoiNumber = $conn->insert_id;
                $_SESSION['eoi_number'] = $eoiNumber;
                header('Location: success.php');
            }

            // close the database connection
            mysqli_close($conn);
        }
    }    
    
    function sanitise_input($data) {
        $data = trim($data);
        $data = stripslashes($data) ;
        $data = htmlspecialchars($data);
        return $data;
    }
?>