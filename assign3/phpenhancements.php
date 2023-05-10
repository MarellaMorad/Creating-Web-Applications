<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Creating Web Applications">
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP, SQL">
    <meta name="author" content="Marella Morad">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>PHP & MySQL Enhancements</title>
    <!--Add a favicon to the website-->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/enhancements.js"></script>
</head>

<body>
    <?php include('header.inc'); include('menu.inc');?>
    <button class="back-to-top hidden"><span class="fa fa-angle-up"></span></button>
    <h1>PHP & MySQL Enhancements</h1>
    <section class="enhance">
        <h2>Implement Manager Sign Up and Login</h2>
        <p class="overall-intro">This feature was implemented to only allow HR Managers to access/modify 
            EOI Applications. The following has been Implemented to achieve this functionality:</p>
        <details>
            <summary>Manager Registration Page - <code>manage.php</code></summary>
            <p>Created a Manager registration page with server-side 
                validation requiring a Unique Username and a Password meeting the TechWave Password Policy:
            </p>
            <ul>
                <li>At least 8 characters long</li>
                <li>Contains at least one uppercase letter (A-Z)</li>
                <li>Contains at least one lowercase letter (a-z)</li>
                <li>Contains at least one digit (0-9)</li>
                <li>Contains at least one special character (e.g. !,@,#,$,%,&,*)</li>
            </ul>
            <p>
                Once the user meets the above requirements, their details are saved in a Manager table in 
                the database.
            </p>
        </details>
        <details>
            <summary>Manager Login Page - <code>login.php</code></summary>
            <p>Created a Manager Login page which authenticates login and records failed login attempts 
                as well as time of failed logins. This information is then saved to the <code>$_SESSION</code> 
                superglobal and is used to disable user access to the website for 30 mins after 3 or more invalid 
                login attempts.
            </p>
            <p>Upon Successful Login, the HR Manager will be able to use all Manager functionalities 
                during a single browser session. Once the browser is closed, the Manager will have to 
                Login again to access the Manager functionalities. This has been implemented by redirecting the 
                users to the sign up / login pages if they try to directly access one of the HR Manager <code>.php</code> 
                files. For example, in <code>displayEOIs.php</code>:
            </p>
            <pre><code>session_start();
if (!isset($_SESSION["loggedin"])) {
    header('Location: manage.php');
    exit;
}
</code></pre>
            <p>
                This check confirms that the user is logged in before allowing them to access any of the Manager functionalities.
            </p>
        </details>
        <details>
        <Summary>Downsides / Vulnerabilities</Summary>
            <p>Even though this feature provides an extra layer of security, allowing only authorized people 
                to access the HR Portal, there are some vulnerabilities that should be noted for future 
                enhancements:
            </p>
            <ol>
                <li>
                    The Sign Up functionality allows any user to Sign up without confirmation of whether this 
                    person is actually from HR or not. This can be enhanced by either:
                    <ul>
                        <li>
                            Adding a table to the database with HR personnel and when a User tries to Sign Up, 
                            their details will be checked against that table and only if found, the User is 
                            allowed to Sign Up.
                        </li>
                        <li>
                            Disabled the Sign Up functionality for external Users and only add HR Users through the 
                            backend.
                        </li>
                    </ul>
                    Both of these suggestions have their downsides as well, which is why I decided to accept the initial 
                    vulnerabilities.
                </li>
                <li>
                    Upon three or more failed login attempts, the User access to TechWave web portal is blocked. Even 
                    though it says the access will be blocked for 30 mins, this only applies for a single Browser Session. 
                    If the User closes and re-opens the browser (i.e. starting a new session), they will be able to try again 
                    for 3 times before they are blocked again (if all 3 attempts fail). In terms of vulnerabilities, this issue is 
                    less concerning when compared to the previous one. I decided to accept the risk and look for better approaches in 
                    the future.
                </li>
            </ol>
        </details>
    </section>
    <section class="enhance">
    <h2>Provide the Manager with the ability to Sort EOIs</h2>
        <details>
            <summary>Basic Required HR Functionalities</summary>
            <p class="overall-intro">In TechWave, a HR Manager has the ability to</p>
        <ol>
            <li>List all EOIs.</li>
            <li>List all EOIs for a particular position (given a job reference number).</li>
            <li>List all EOIs for a particular applicant given their first name, last name or both.</li>
            <li>Delete all EOIs with a specified job reference number</li>
            <li>Change the Status of an EOI.</li>
        </ol>
        <p>The above functionalities have been implemented using three <code>.php</code> files</p>
        <ol>
            <li>
                <code>displayEOIs.php</code>:
                <p>
                    This file provides the first three listing functionalities based on the user preference. 
                    For example, if the user chooses not to fill in any of the search filters, the system will 
                    list all available EOIs. Otherwise, if they do select/fill in a filter, then the SQL query 
                    will be modified accordingly using if conditions and dynamic string building.
                </p>
            </li>
            <li>
                <code>deleteEOIs.php</code>
                <p>This file basically deletes all EOI applications that match to a given job reference number.</p>
            </li>
            <li>
                <code>updateEOIStatus.php</code>
                <p>This file updates the Status of a specific EOI application (using EOInumber) and the new Status that 
                    the HR Manager selects to update the record with.
                </p>
            </li>
        </ol>
        </details>
        <details>
            <summary>Added a Dropdown Filter to the <code>displayEOIs.php</code></summary>
            <p>
                As part of the searching functionality that HR Managers have access to, I added a dropdown filter that includes some 
                of the EOI table columns to allow the Manager to order results based on their selection. I used dynamic strings to build 
                the query based on whether the Manager has selected an Order option or not.
            </p>
        </details>
    </section>
    <?php include('footer.inc'); ?>
</body>

</html>