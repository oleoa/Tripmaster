import { Calendar } from '@fullcalendar/core';
import interactionPlugin from '@fullcalendar/interaction';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', function() {
    
  let startInput = document.getElementById('start');
  let endInput = document.getElementById('end');
  let calendarEl = document.getElementById('calendar');

  let calendar = new Calendar(calendarEl, {

    plugins: [ interactionPlugin, dayGridPlugin ],

    initialView: 'dayGridMonth',

    selectable: true,

    unselectAuto: false,

    select: function(info) {
      
      let start = info.startStr;

      let end = info.endStr;

      startInput.value = start;

      endInput.value = end;
      
    }
  });

  calendar.render()
  
});
