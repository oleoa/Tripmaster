import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';

let rents = [];
let input = document.getElementById('rents');
if (input)
  rents = JSON.parse(input.value);

var eventsData = [];

for (let rent of rents) {
  eventsData.push({
    start: rent.start_date,
    end: rent.end_date,
    display: 'background'
  });
}

var calendarEl = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarEl, {

  initialView: 'dayGridMonth',

  allDaySlot: false,

  weekends: true,

  events: eventsData,

});

calendar.render();
