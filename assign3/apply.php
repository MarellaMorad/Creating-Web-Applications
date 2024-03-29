<?php
    session_start();
    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : null;
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
    <title>Application of Interest</title>
    <!--Add a favicon to the website-->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/enhancements.js"></script>
    <script src="scripts/applyNoValidation.js"></script>
</head>

<body>
    <?php
        include('header.inc'); 
        include('menu.inc');
    ?>
    <button class="back-to-top hidden"><span class="fa fa-angle-up"></span></button>
    <h1>Application of Interest</h1>
    <div id="warning">
        <span id="warning-content">Some Items Require Your Attention!</span>
    </div>
    <?php
        if ($errors) {
            echo '<script>
                    document.getElementById("warning").style.display = "flex";
                  </script>';
        }
    ?>
    <form class="form-container" method="post" id="application-form" action="processEOI.php" novalidate="novalidate">
        <p>
            <label class="required" for="reference-number">Job Reference Number:</label>
            <span class="with-validation">
                <input type="text" name="reference-number" id="reference-number">
                <span class="error-message" id="reference-number-err"></span>
            </span>
            <input type="hidden" name="job-reference-number" id="job-reference-number">
        </p>
        <?php
            if (isset($errors['reference-number'])) {
                echo 
                '<script>
                    document.getElementById("reference-number").classList.add("invalid");
                    document.getElementById("reference-number-err").textContent = "' . $errors['reference-number'] . '";
                </script>';
            }
        ?>
        <fieldset>
            <legend>Personal Details</legend>
            <p>
                <label class="required" for="first-name">First Name:</label>
                <span class="with-validation">
                    <input type="text" name="first-name" id="first-name">
                    <span class="error-message" id="first-name-err"></span>
                </span>
            </p>
            <?php
                if (isset($errors['firstname'])) {
                    echo 
                       '<script>
                            document.getElementById("first-name").classList.add("invalid");
                            document.getElementById("first-name-err").textContent = "' . $errors['firstname'] . '";
                        </script>';
                }
            ?>
            <p>
                <label class="required" for="last-name">Last Name:</label>
                <span class="with-validation">
                    <input type="text" name="last-name" id="last-name">
                    <span class="error-message" id="last-name-err"></span>
                </span>
            </p>
            <?php
                if (isset($errors['lastname'])) {
                    echo 
                       '<script>
                            document.getElementById("last-name").classList.add("invalid");
                            document.getElementById("last-name-err").textContent = "' . $errors['lastname'] . '";
                        </script>';
                }
            ?>
            <p>
                <label class="required" for="dob">Date of Birth:</label>
                <span class="with-validation">
                    <input type="text" name="dob" id="dob" placeholder="dd/mm/yyyy">
                    <span class="error-message" id="dob-err"></span>
                </span>
            </p>
            <?php 
                if (isset($errors['dob'])) {
                    echo 
                        '<script>
                            document.getElementById("dob").classList.add("invalid");
                            document.getElementById("dob-err").textContent = "' . $errors['dob'] . '";
                        </script>';
                }
            ?>
            <fieldset id="gender">
                <legend class="required">Gender:</legend>
                <label for="male">Male</label>
                <input type="radio" id="male" name="gender" value="male">

                <label for="female">Female</label>
                <input type="radio" id="female" name="gender" value="female">
            </fieldset>
            <span id="gender-with-validation">
                <span class="error-message" id="gender-err"></span>
            </span>
            <?php 
                if (isset($errors['gender'])) {
                    echo 
                        '<script>
                            document.getElementById("gender").classList.add("invalid");
                            document.getElementById("gender-err").textContent = "' . $errors['gender'] . '";
                        </script>';
                }
            ?>
        </fieldset>
        <fieldset>
            <legend>Contact Information</legend>
            <fieldset>
                <legend>Address</legend>
                <p>
                    <label class="required" for="street">Street Address:</label>
                    <span class="with-validation">
                        <input type="text" name="street" id="street">
                        <span class="error-message" id="street-err"></span>
                    </span>
                </p>
                <?php 
                    if (isset($errors['street'])) {
                        echo 
                            '<script>
                                document.getElementById("street").classList.add("invalid");
                                document.getElementById("street-err").textContent = "' . $errors['street'] . '";
                            </script>';
                    }
                ?>
                <p>
                    <label class="required" for="suburb">Suburb/town:</label>
                    <span class="with-validation">
                        <input type="text" name="suburb" id="suburb">
                        <span class="error-message" id="suburb-err"></span>
                    </span>
                </p>
                <?php 
                    if (isset($errors['suburb'])) {
                        echo 
                            '<script>
                                document.getElementById("suburb").classList.add("invalid");
                                document.getElementById("suburb-err").textContent = "' . $errors['suburb'] . '";
                            </script>';
                    }
                ?>
                <p>
                    <label class="required" for="state">State:</label>
                    <span class="with-validation">
                        <select name="state" id="state">
                            <option value="">Please Select</option>
                            <option value="vic">VIC</option>
                            <option value="nsw">NSW</option>
                            <option value="qld">QLD</option>
                            <option value="nt">NT</option>
                            <option value="wa">WA</option>
                            <option value="sa">SA</option>
                            <option value="tas">TAS</option>
                            <option value="act">ACT</option>
                        </select>
                        <span class="error-message" id="state-err"></span>
                    </span>
                </p>
                <?php 
                    if (isset($errors['state'])) {
                        echo 
                            '<script>
                                document.getElementById("state").classList.add("invalid");
                                document.getElementById("state-err").textContent = "' . $errors['state'] . '";
                            </script>';
                    }
                ?>
                <p>
                    <label class="required" for="postcode">Postcode:</label>
                    <span class="with-validation">
                        <input type="text" name="postcode" id="postcode">
                        <span class="error-message" id="postcode-err"></span>
                    </span>
                </p>
                <?php 
                    if (isset($errors['postcode'])) {
                        echo 
                            '<script>
                                document.getElementById("postcode").classList.add("invalid");
                                document.getElementById("postcode-err").textContent = "' . $errors['postcode'] . '";
                            </script>';
                    }
                ?>
            </fieldset>
            <p>
                <label class="required" for="email">Email Address:</label>
                <span class="with-validation">
                    <input type="text" name="email" id="email">
                    <span class="error-message" id="email-err"></span>
                </span>
            </p>
            <?php 
                if (isset($errors['email'])) {
                    echo 
                        '<script>
                            document.getElementById("email").classList.add("invalid");
                            document.getElementById("email-err").textContent = "' . $errors['email'] . '";
                        </script>';
                }
            ?>
            <p>
                <label class="required" for="mobile">Phone Number:</label>
                <span class="with-validation">
                    <input type="text" name="mobile" id="mobile">
                    <span class="error-message" id="mobile-err"></span>
                </span>
            </p>
            <?php 
                if (isset($errors['mobile'])) {
                    echo 
                        '<script>
                            document.getElementById("mobile").classList.add("invalid");
                            document.getElementById("mobile-err").textContent = "' . $errors['mobile'] . '";
                        </script>';
                }
            ?>
        </fieldset>
        <fieldset>
            <legend>Skills (select all that apply)</legend>
            <fieldset id="bda-skills">
                <legend>Big Data Analyst Specific Skills</legend>
                <label for="hadoop">Hadoop</label>
                <input type="checkbox" id="hadoop" name="skills[]" value="hadoop">

                <label for="spark">Spark</label>
                <input type="checkbox" id="spark" name="skills[]" value="spark">

                <label for="tableau">Tableau</label>
                <input type="checkbox" id="tableau" name="skills[]" value="tableau">

                <label for="power-bi">Power BI</label>
                <input type="checkbox" id="power-bi" name="skills[]" value="power-bi">
            </fieldset>
            <fieldset id="swe-skills">
                <legend>Software Engineer Specific Skills</legend>
                <label for="c-sharp">C#</label>
                <input type="checkbox" id="c-sharp" name="skills[]" value="c-sharp">

                <label for="c-plus-plus">C++</label>
                <input type="checkbox" id="c-plus-plus" name="skills[]" value="c-plus-plus">

                <label for="agile">Agile</label>
                <input type="checkbox" id="agile" name="skills[]" value="agile">

                <label for="scrum">Scrum</label>
                <input type="checkbox" id="scrum" name="skills[]" value="scrum">

                <label for="git">Git</label>
                <input type="checkbox" id="git" name="skills[]" value="git">

                <label for="jira">JIRA</label>
                <input type="checkbox" id="jira" name="skills[]" value="jira">

                <label for="jenkins">Jenkins</label>
                <input type="checkbox" id="jenkins" name="skills[]" value="jenkins">
            </fieldset>
            <fieldset>
                <legend>Soft Skills</legend>
                <label for="problem-solving">Problem Solving Skills</label>
                <input type="checkbox" id="problem-solving" name="skills[]" value="problem-solving">

                <label for="communication">Communication skills</label>
                <input type="checkbox" id="communication" name="skills[]" value="communication">

                <label for="teamwork">Teamwork Skills</label>
                <input type="checkbox" id="teamwork" name="skills[]" value="teamwork">

                <label for="other-skills">Other skills...</label>
                <input type="checkbox" id="other-skills" name="skills[]" value="other-skills">
            </fieldset>
            <p>
                <label for="other-skills-desc">Other Skills:</label>
                <span class="with-validation">
                    <textarea id="other-skills-desc" name="other-skills-desc" rows="4" cols="40"
                        placeholder="Please list your other skills here..."></textarea>
                    <span class="error-message" id="other-skills-desc-err"></span>
                </span>
            </p>
            <?php 
                if (isset($errors['other-skills-desc'])) {
                    echo 
                        '<script>
                            document.getElementById("other-skills-desc").classList.add("invalid");
                            document.getElementById("other-skills-desc-err").textContent = "' . $errors['other-skills-desc'] . '";
                        </script>';
                }
            ?>
        </fieldset>
        <div class="buttons">
            <input type="submit" value="Apply">
            <input type="reset" value="Reset form">
        </div>
        <?php 
            // clear the session variable so the errors don't persist after a refresh
            unset($_SESSION['errors']);
            unset($_SESSION['direct-access']);
        ?>
    </form>
    <?php include('footer.inc'); ?>
</body>

</html>