<form class="form-container manager-actions" method="post">
    <h2>Change the Status of EOI Applications</h2>
    <p>
        <label class="required" for="eoi_number">EOI Number:</label>
        <input type="text" name="eoi_number" id="eoi_number" placeholder="Enter the unique EOI number for the Application you wish to Update">
    </p>

    <p>
        <label class="required" for="new_status">New Status:</label>
        <select name="new_status" id="new_status">
            <option value="">Please Select</option>
            <option value="New">New</option>
            <option value="Current">Current</option>
            <option value="Final">Final</option>
        </select>
    </p>
    <div class="buttons">
        <input type="submit" name="update-status" value="Update Status">
    </div>
    <input type="hidden" name="action" value="updateEOIStatus">
</form>