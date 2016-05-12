<p>
    Friends or family coming to stay at your HostKeep managed property? Please let us know below. Requests take up to 24hrs to be processed and calendar blocked out.
</p>

<div id='directBookingAdd'>
    <button id='directBookingShowAdd'>Show Add New Booking</button>
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
            <label for="#directBookingAddInvoice">Guest Invoiced?</label>
            <input id='directBookingAddInvoice' type='checkbox' />
        </div>

        <div>
            <label for="#directBookingAddCleanUp">Post check-out cleanup needed?</label>
            <input id='directBookingAddCleanUp' type='checkbox' />
        </div>

        <div>
            <button id='directBookingAddButton'>Add New Booking</button>
        </div>
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
