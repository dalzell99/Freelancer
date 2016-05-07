<div id='documentsAdd'>
    <button id='documentsShowAdd'>Show Add New Document</button>
    <div id='documentsAddNewDocument'>
        <div>
            <label for="#documentsAddName">Name</label>
            <input id='documentsAddName' type='text' />
        </div>

        <div>
            <label for="#documentsAddPropertyID">Property</label>
            <select id='documentsAddPropertyID'></select>
        </div>

        <div>
            <label for="#documentsAddMonth">Month</label>
            <select id='documentsAddMonth'>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
            </select>
        </div>

        <div>
            <label for="#documentsAddNotes">Notes</label>
            <textarea id='documentsAddNotes' lines='4'></textarea>
        </div>

        <div>
            <button type='submit' id='documentsAddButton'>Add New Document</button>
        </div>

        <form id='documentsDropzone' class='dropzone' action='php/documents/uploaddocument.php'>
            <div class="fallback">
                <input name="file" type="file" />
            </div>
        </form>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>
                Report
            </th>
            <th>
                Property
            </th>
            <th>
                Month
            </th>
            <th>
                Date Uploaded
            </th>
            <th>
                Notes
            </th>
        </tr>
    </thead>
    <tbody>
        <!-- Documents dynamically added here -->
    </tbody>
</table>
