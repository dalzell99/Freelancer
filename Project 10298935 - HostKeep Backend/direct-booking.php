<p>
    Friends or family coming to stay at your HostKeep managed property? Please let us know below. Requests take up to 24hrs to be processed and calendar blocked out.
</p>

<p>
    <strong>Please note, the calendar does not display existing guest booking. If there is an conflict with dates, we will be in touch.</strong>
</p>

<div id='directBookingAddNewBooking'>
    <div>
        <label for="#directBookingAddProperty">Property</label>
        <select id='directBookingAddProperty'></select>
    </div>

    <div>
        <label for="#directBookingAddGuestName">Guest Name</label>
        <input id='directBookingAddGuestName' type='text' />
    </div>

    <div>
        <label for="#directBookingAddGuestMobile">Guest Mobile</label>
        <input id='directBookingAddGuestMobile' type='text' />
    </div>

    <div>
        <label for="#directBookingAddGuestEmail">Guest Email</label>
        <input id='directBookingAddGuestEmail' type='text' />
    </div>

    <div>
        <label for="#directBookingAddCheckIn">Check-in Date</label>
        <input id='directBookingAddCheckIn' type='date' />
    </div>

    <div>
        <label for="#directBookingAddCheckOut">Check-out Date</label>
        <input id='directBookingAddCheckOut' type='date' />
    </div>

    <div>
        <label for="#directBookingAddNotes">Notes</label>
        <textarea id='directBookingAddNotes' rows='4'></textarea>
    </div>

    <div>
        <label for="#directBookingAddCleanUp">Post check-out cleanup</label>
        <select id='directBookingAddCleanUp'>
            <option value="Guest">Guest will complete the clean and laundry ready for next guest</option>
            <option value="HostKeep">HostKeep to complete clean and invoice guest</option>
        </select>
    </div>

    <div>
        <input id='directBookingAddInvoice' type='checkbox' />
        <label for="#directBookingAddInvoice">Does your guest need to be be invoiced for this booking?</label>
    </div>

    <div>
        <button id='directBookingAddButton'>Add New Booking</button>
    </div>
</div>

<table id='bookingTable'>
    <thead>
        <tr>
            <th>
                Property
            </th>
            <th>
                Guest
            </th>
            <th>
                Check-In
            </th>
            <th>
                Check-Out
            </th>
            <th>
                Invoice
            </th>
            <th>
                Cleanup
            </th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
