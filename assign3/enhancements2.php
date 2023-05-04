<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Creating Web Applications">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="Marella Morad">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>JavaScript Enhancements</title>
    <!--Add a favicon to the website-->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/enhancements.js"></script>
</head>

<body>
    <div id="logo-container">
        <a href="index.html"><img id="logo" src="images/fullLogo.png" alt="TechWave Logo"></a>
    </div>
    <?php include('header.inc'); ?>
    <button class="back-to-top hidden"><span class="fa fa-angle-up"></span></button>
    <h1>JavaScript Enhancements</h1>
    <section class="enhance">
        <h2>Responsive Design</h2>
        <p class="overall-intro">
            This enhancement includes some JavaScript functions that are applied to html pages/elements to provide the
            user with a better, more intuitive user experience.
        </p>
        <details>
            <summary>Responsive Form Validation using Event Listeners</summary>
            <p>
                Using event listeners allows for responsive validation, which can improve the user experience by
                providing immediate feedback to the user if they have made a mistake. This can also help prevent users
                from submitting forms with incorrect data, saving time and effort for both the user and the developer.
            </p>
            <h3>Trigger:</h3>
            <p class="desc">
                A user simply needs to start typing in a form input field. As they type, the validation function
                associated with that field is called to check the input and display any error messages if necessary.
            </p>
            <h3>Implementation:</h3>
            <p class="desc">
                I added event listeners to the form inputs that trigger
                validation functions as the user enters data. To do that,I used <code class="line-code">input.addEventListener("input",
                    validationFunction())</code> to add an event listener to an input element that calls the
                <code>validationFunction()</code>
                every time the user enters data. Within the <code class="line-code">validationFunction()</code>, the
                user input gets
                checked and if not valid an appropriate error message gets displayed.
            </p>
            <p class="desc">
                Instead of grouping the error messages and displaying them in an alert box, I used <code
                    class="line-code">span</code>
                elements to display an error underneath each input field that has invalid data. Each span shows a
                relevant message regarding the validation of the data.
            </p>
            <h3>Link to Enhancement in Action:</h3>
            <p class="desc">This can be seen in action on the <a href="apply.html">Join Us</a> page</p>
            <h3>Third-Party References:</h3>
            <p class="desc">
                Mozilla Web Docs - <a
                    href="https://developer.mozilla.org/en-US/docs/web/api/eventtarget/addeventlistener"><code
                        class="line-code">addEventListener()</code></a>
                method
            </p>
        </details>
        <details>
            <summary>Improved website navigation with dynamic menu rendering using JavaScript</summary>
            <p>
                This has been implemented to enhances the responsiveness of my website by using JavaScript to render and
                style the appropriate menu, based on the screen size. This allows the website to adapt to different
                screen sizes and provides a better user experience. It also eliminated the need for a second hard coded
                menu to be used on smaller screens.
            </p>
            <h3>Trigger:</h3>
            <p class="desc">
                To trigger the event, a user would simply adjust the screen size (either increase or decrease) and the
                menu will respond accordingly. Also, when a user selects a certain page, the menu item of that page
                would be styled differently indicating the active page.
            </p>
            <h3>Implementation:</h3>
            <p class="desc">
                To implement the feature, I created a new JS file - <code class="line-code">enhancements.js</code> - and
                defined two main functions:
            </p>
            <ul>
                <li>
                    <code class="line-code">adjustMenu():</code>
                    <p>
                        This function computes the screen size using <code class="line-code">window.innerWidth</code>
                        and applies CS
                        styling to the menu elements accordingly. The CS styling is added from an external CS stylesheet
                        called fontAwesomeIcons by adding relevant classes to each of the menu items and removing them
                        on larger screens.
                    </p>
                </li>
                <li>
                    <code class="line-code">setActivePage()</code>
                    <p>
                        This function relies on the <code class="line-code">window.location.href</code> property and
                        compares it to the
                        list of <code class="line-code">nav-links</code> and once they are equal, adds the <code
                            class="line-code">active</code> class to
                        the active page.
                    </p>
                </li>
            </ul>
            <h3>Link to Enhancement in Action:</h3>
            <p class="desc">
                You can see the implementation of dynamic menu rendering throughout my website. For example, if you
                resize the browser window or view the website on a mobile device, you will notice that the layout and
                styling of the website adjusts accordingly. One main thing that you may notice is the navbar items
                changing from <strong>text</strong> (on large screens) to
                <strong><a href="https://fontawesome.com/icons">Font Awesome</a>
                    icons</strong>
                (on medium and small screens).
            </p>
            <h3>Third-Party References:</h3>
            <p class="desc">
                One of the main sources for this implementation is <a
                    href="https://www.tutorialstonight.com/javascript-add-class#:~:text=Add%20class%20javascript%20-%203%20ways%201%201.,a%20string.%20...%203%203.%20Using%20setAttribute%20Method">Tutorials
                    Tonight</a>
                for instructions on using <code class="line-code">classList.add()</code> and <code
                    class="line-code">classList.remove()</code>
            </p>
        </details>
        <details>
            <summary>Improved website navigation with a Back To Top button</summary>
            <p>
                The addition of the Back To Top button is to help users quickly navigate back to the top of the page
                without having to scroll manually, saving them time and effort. It also gives the user instant access to
                the main menu as it is located at the top of the screen.
            </p>
            <h3>Trigger:</h3>
            <p class="desc">To activate the back-to-top button visibility, the user needs to scroll down until the
                top menu becomes invisible. Then the back-to-top button will become visible, and clicking on it will
                scroll back to the top of the page.</p>
            <h3>Implementation:</h3>
            <p class="desc">
                To implement this, I used the window <code>scroll</code> event listener to toggle the display of the
                back to top button. Then I used the button <code>click</code> event listener to scroll the window back
                up once the button is clicked.
            </p>
            <pre><code>  window.scrollTo({
      top: 0,
      behavior: "smooth"
  });</code></pre>
            <h3>Link to Enhancement in Action:</h3>
            <p class="desc">This enhancement has been implemented on all screens and is activated as soon as the top
                logo of the screen becomes invisible</p>
            <h3>Third-Party References:</h3>
            <p class="desc">One of the really helpful websites was the <a
                    href="https://www.w3schools.com/howto/howto_js_scroll_to_top.asp">W3School</a> explaining the
                required steps to create a Scroll to Top button.</p>
        </details>
        <details>
            <summary>Filter the Skills Checkboxes based on the Selected Job Reference Number</summary>
            <p>
                This enhancement was made to improve user experience and provide a more personalized application form.
                By
                only showing the relevant checkboxes, users are not overwhelmed with unnecessary options and can quickly
                find and select the relevant options for their specific job.
            </p>
            <h3>Trigger:</h3>
            <p class="desc">
                When the user selects a Job Reference Number, the Skills checkboxes will be filtered based on the user
                choice.
                For example, if the user selects Big Data Analyst role, only the Big Data Analyst skills checkboxes will
                be displayed.
            </p>
            <h3>Implementation:</h3>
            <p class="desc">
                To implement this, I wrote a function in JS that toggles the display of these checkboxes based on the
                selected reference number:
            </p>
            <pre><code>  function filterSkillsList(refNumValue, bdaSkillsFieldset, sweSkillsFieldset) {
      sweSkillsFieldset.style.display = (refNumValue === "swetw") ? "" : "none";
      bdaSkillsFieldset.style.display = (refNumValue === "bdatw") ? "" : "none";
  }</code></pre>
            <h3>Link to Enhancement in Action:</h3>
            <p class="desc">
                This has been implemented on the <a href="apply.html">Job Application</a> page.
            </p>
            <h3>Third-Party References:</h3>
            <p class="desc">No Third-Party references have been used for this part as I relied on my experience with
                JavaScript.</p>
        </details>
    </section>
    <section class="enhance">
        <h2>Code Refactoring</h2>
        <p class="overall-intro">
            This enhancement involved restructuring the validation code to make it more modular and easier to maintain.
            This was done in three steps:
        </p>
        <details>
            <summary>Defining a Class to Manage Form Fields</summary>
            <p>
                This enhancement was made to promote encapsulation, reusability, extensibility, and
                abstraction. It enabled me to group relevant information of a field into a single unit, making it easier
                to manage the form field's state and behavior, and create multiple instances without repeating code. It
                provided a higher level of abstraction, allowing me to focus on the form field's behavior
                and state rather than managing individual variables and event listeners.
            </p>
            <h3>Trigger</h3>
            <p class="desc">There isn't a specific trigger for the user to run this enhancement. However, as the website
                grows, the user will still enjoy smooth responsiveness.</p>
            <h3>Implementation</h3>
            <p class="desc">To implement this, I first defined a class using the following:</p>
            <!--Pre element to display code-->
            <pre><code>  class FormField {
      constructor(inputId, errId, validateFn) {
          this.input = document.getElementById(inputId);
          this.errSpan = document.getElementById(errId);
          this.validate = validateFn.bind(this);
          this.input.addEventListener("input", this.validate);
      }
  }</code></pre>
            <p class="desc">Which then enabled me to change my code from <strong>this</strong>:</p>
            <pre><code>  const firstName = document.getElementById("first-name"); 
  const firstNameErr = document.getElementById("first-name-err"); 
  firstName.addEventListener('input', function () { 
      validateName(this.input, this.errSpan, "First Name"); 
  });</code></pre>
            <p class="desc"><strong>To this</strong>:</p>
            <pre><code>  const firstNameField = new FormField("first-name", "first-name-err", function () { 
      validateName(this.input, this.errSpan, "First Name"); 
  });</code></pre>
            <p class="desc">
                Following this approach allowed me to use less variables, less duplication of code, further organization
                to my code and implement typechecking on my form fields.
            </p>
            <h3>Link to Enhancement in Action:</h3>
            <p class="desc">This enhancement is applicable to the Join Us page as it's included in the apply.js file
                that
                validations the <a href="apply.html">Join Us form</a>.</p>
            <h3>Third-Party References:</h3>
            <p class="desc">I relied on the Classes definition documentation from the <a
                    href="https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Classes">Mozilla Web
                    Docs</a> to create the FormFields class.</p>
        </details>
        <details>
            <summary>Breaking the big validation function into smaller functions</summary>
            <p>
                This enhancement is common practice in software development to improve code Maintainability,
                Understandability, Reusability, and Debugging. I chose this approach as some of the form fields
                share the same validation, for example: firstName and lastName should both be alphabetical characters,
                with a maximum of 20 characters.
            </p>
            <h3>Trigger:</h3>
            <p class="desc">There isn't a specific trigger for the user to run this enhancement. However, as the website
                grows, the user will still enjoy smooth responsiveness and consistent performance.</p>
            <h3>Implementation:</h3>
            <p class="desc">
                To implement this, I broke down the <code class="line-code">validate()</code> function into the
                following functions:
            </p>
            <ul>
                <li><code class="line-code">validateJobRefNum()</code></li>
                <li><code class="line-code">validateName()</code></li>
                <li><code class="line-code">validateDOB()</code></li>
                <li><code class="line-code">validateGender()</code></li>
                <li><code class="line-code">validateAddress()</code></li>
                <li><code class="line-code">validateState()</code></li>
                <li><code class="line-code">validatePostcode()</code></li>
                <li><code class="line-code">validateStatePostcode()</code></li>
                <li><code class="line-code">validateEmail()</code></li>
                <li><code class="line-code">validateMobileNumber()</code></li>
                <li><code class="line-code">validateOtherSkillsDesc()</code></li>
            </ul>
            <p class="desc">Each function is specified to validate at least one form input element and it returns a
                boolean indicating whether or not the user input is valid or not.
            </p>
            <p class="desc">
                To further refactor my code, I used some <strong>helper</strong> functions, such as the
                <code class="line-code">validateInput()</code>
                function which takes in the input element, and validates if it has a value, and also checks if it meets
                the given regex (when applicable). This drastically reduced the amount of
                code duplication that would have been included otherwise.
            </p>
            <h3>Link to Enhancement in Action:</h3>
            <p class="desc">This enhancement is applicable to the Join Us page as it's included in the apply.js file
                that
                validations the <a href="apply.html">Join Us form</a>.</p>
            <h3>Third-Party References:</h3>
            <p class="desc">No Third-Party references have been used for this part as I relied on my experience with
                code refactoring.</p>
        </details>
        <details>
            <summary>Defining Form Fields and passing them around functions instead of calling
                <code class="line-code">document.getElementById</code> Multiple times
            </summary>
            <p>
                This last step depends on the previous two steps in the sense that having the FormFields Class, and
                Refactoring into small functions enabled me to do this step to further improve the performance and
                readability of me code.
            </p>
            <h3>Trigger:</h3>
            <p class="desc">There isn't a specific trigger for the user to run this enhancement. However, as the website
                grows, the user will still enjoy smooth responsiveness and consistent performance.</p>
            <h3>Implementation:</h3>
            <p class="desc">
                I defined all the relevant form elements in the <code class="line-code">init()</code> function then
                passed them around to
                the relevant functions.
            </p>
            <pre><code>  const refNumField = new FormField("reference-number", "reference-number-err", function () {
      validateJobRefNum(this.input, this.errSpan, bdaSkillsFieldset, seSkillsFieldset);
  });
  const firstNameField = new FormField("first-name", "first-name-err", function () {
      validateName(this.input, this.errSpan, "First Name");
  });</code></pre>
            <p class="desc">Then all these variables were also passed into the <code
                    class="line-code">runAllValidations()</code> function
                which runs all the validations one more time when the form is submitted (i.e. the Apply button is
                clicked).</p>
            <h3>Link to Enhancement in Action:</h3>
            <p class="desc">This enhancement is applicable to the Join Us page as it's included in the apply.js file
                that
                validations the <a href="apply.html">Join Us form</a>.</p>
            <h3>Third-Party References:</h3>
            <p class="desc">No Third-Party references have been used for this part as I relied on my experience with
                code refactoring.</p>
        </details>
    </section>
    <footer>© 2023 TechWave All Rights Reserved.</footer>
</body>

</html>