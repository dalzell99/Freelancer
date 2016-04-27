<div id='propertiesAdd'>
    <button id='propertiesShowAdd'>Show Add New Property</button>
    <div id='propertiesAddNewProperty'>
        <div>
            <label for="#propertiesAddName">Name</label>
            <input id='propertiesAddName' type='text' />
        </div>
        <div>
            <label for="#propertiesAddDescription">Description</label>
            <textarea id='propertiesAddDescription' lines='4'></textarea>
        </div>
        <div>
            <label for="#propertiesAddAddress">Address</label>
            <textarea id='propertiesAddAddress' lines='4'></textarea>
        </div>
        <div>
            <label for="#propertiesAddPrice">Minimum Nightly Price</label>
            <input id='propertiesAddPrice' type='number' />
        </div>
        <div>
            <button id='propertiesAddButton'>Add New Property</button>
        </div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                Description
            </th>
            <th>
                Address
            </th>
            <th>
                Minimum Nightly Price
            </th>
        </tr>
    </thead>
    <tbody>
        <!-- Properties dynamically added here -->
    </tbody>
</table>
