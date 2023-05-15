<form class="form-container manager-actions" method="post">
    <h2>Display EOI Applications</h2>
    <p><span class="fa fa-info-circle"></span>If you want to display all EOIs that are present in the database, leave all the filters unset.</p>
    <p>
        <label for="search-reference-number">Job Reference Number:</label>
        <input type="text" name="search-reference-number" id="search-reference-number">
    </p>
    <p>
        <label for="search-first-name">First Name:</label>
        <input type="text" name="search-first-name" id="search-first-name">
    </p>
    <p>
        <label for="search-last-name">Last Name:</label>
        <input type="text" name="search-last-name" id="search-last-name">
    </p>
    <p>
        <label for="sort">Sort Results By:</label>
        <select name="sort" id="sort">
            <option value="">Please Select</option>
            <option value="JobReferenceNumber">Job Reference Number</option>
            <option value="FirstName">Firstname</option>
            <option value="LastName">Lastname</option>
        </select>
    </p>
    <div class="buttons">
        <input type="submit" name="search" value="Search">
    </div>
    <input type="hidden" name="action" value="displayEOIs">
</form>