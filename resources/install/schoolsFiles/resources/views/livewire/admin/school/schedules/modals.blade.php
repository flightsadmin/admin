<div wire:ignore.self class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Create Timetable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group col mb-2">
                    <label for="event-name">Subject</label>
                    <input type="text" class="form-control form-control-sm" id="event-name" placeholder="Subject">
                </div>
                <div class="form-group col mb-2">
                    <label for="event-start">Start</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="event-start">
                </div>
                <div class="form-group col mb-2">
                    <label for="event-end">End</label>
                    <input type="datetime-local" class="form-control form-control-sm" id="event-end">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-event">Save</button>
            </div>
        </div>
    </div>
</div>
