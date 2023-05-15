<form class="form-container manager-actions" method="post">
    <h2>Delete EOI Applications</h2>
    <p><span class="fa fa-exclamation-triangle"></span>Warning: Use this function CAREFULLY as once you click on the delete button, ALL records that match the filters will be DELETED FOREVER!</p>
    <p>
        <label class="required" for="delete-reference-number">Job Reference Number:</label>
        <input type="text" name="delete-reference-number" id="delete-reference-number">
    </p>
    <div class="buttons">
        <input type="submit" name="delete" value="Delete">
    </div>
    <input type="hidden" name="action" value="deleteEOIs">
</form>