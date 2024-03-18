<div>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <div class="card shadow">
        <div class="card-body">
            <div wire:ignore id='calendar'></div>
        </div>
    </div>

    @include('livewire.school.schedules.modals')

    <script>
        document.addEventListener('livewire:initialized', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: @json($timetables),
                select: function(data) {
                    var modal = new bootstrap.Modal('#eventModal');
                    var saveButton = document.getElementById('save-event');
                    var eventInput = document.getElementById('event-name');
                    var eventStart = document.getElementById('event-start');
                    var eventEnd = document.getElementById('event-end');

                    // Format the date to "YYYY-MM-DDTHH:MM"
                    var selectedStartDate = data.start.toISOString().slice(0, 16);
                    var selectedEndDate = data.end.toISOString().slice(0, 16);

                    eventInput.value = "Hello";
                    eventStart.value = selectedStartDate;
                    eventEnd.value = selectedEndDate;
                    modal.show();

                    saveButton.addEventListener('click', function() {
                        var event_name = eventInput.value;
                        var event_start = eventStart.value;
                        var event_end = eventEnd.value;
                        console.log(event_name, event_start, event_end);
                        if (event_name && event_start && event_end) {
                            modal.hide();
                            eventInput.value = '';
                            eventStart.value = '';
                            eventEnd.value = '';
                            @this.newTimetable(event_name, event_start, event_end)
                                .then(function(id) {
                                    calendar.addEvent({
                                        id: id,
                                        title: event_name,
                                        start: event_start,
                                        end: event_end,
                                    });
                                    calendar.unselect();
                                });
                        }
                    });
                },
                eventClick: function(data) {
                    var newTitle = prompt('Edit Timetable Name:', data.event.title);
                    if (newTitle) {
                        data.event.setProp('title', newTitle);
                        @this.updateTimetable(
                            data.event.id,
                            newTitle,
                            data.event.start.toISOString(),
                            data.event.end.toISOString()
                        ).then(function() {
                            console.log('Edited event');
                        });
                    }
                },
                eventDrop: function(data) {
                    @this.updateTimetable(
                        data.event.id,
                        data.event.title,
                        data.event.start.toISOString(),
                        data.event.end.toISOString()
                    ).then(function() {
                        console.log('Moved event');
                    });
                }
            });
            calendar.render();
        });
    </script>
</div>
