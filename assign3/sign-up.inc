<h1>HR Manager Registration</h1>
<div class="login-forms form-container">
    <form method="post" action="manage.php" id="sign-up-form">
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
            <input type="submit" name="sign-up" value="SIGN UP">
        </div>
        <p>Already a user?&nbsp;<a href="login.php">LOGIN</a></p>
    </form>
</div>