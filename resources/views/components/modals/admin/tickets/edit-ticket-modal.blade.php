<!-- Modal -->
<div class="modal fade" id="editTicketModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Ticket</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTicketForm">
                <div class="modal-body">
                    <input type="hidden" name="ticket_id" id="editTicketId">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="title" id="editTitle"
                            placeholder="name@example.com">
                        <label for="floatingInput">Title</label>
                        <span class="invalid-feedback" id="editTitleInvalid"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" name="message" id="editMessage" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Message</label>
                        <span class="invalid-feedback" id="editMessageInvalid"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="department" id="editDepartment">
                            <option value="">Select a Department</option>
                        </select>
                        <label for="floatingSelect">Department</label>
                        <span class="invalid-feedback" id="editDepartmentInvalid"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="editCategory" name="category">
                            <option value="">Select a Ticket Category</option>
                        </select>
                        <label for="floatingSelect">Ticket Category</label>
                        <span class="invalid-feedback" id="editCategoryInvalid"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="editPriority" name="priority">
                            <option value="">Select a Priority</option>
                            <option value="0">Low</option>
                            <option value="1">Mid</option>
                            <option value="2">High</option>
                        </select>
                        <label for="floatingSelect">Priority</label>
                        <span class="invalid-feedback" id="editPriorityInvalid"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="editStatus" name="status">
                            <option value="">Select a Status</option>
                            <option value="0">Pending</option>
                            <option value="1">On Going</option>
                            <option value="2">Solved</option>
                        </select>
                        <label for="floatingSelect">Status</label>
                        <span class="invalid-feedback" id="editStatusInvalid"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary editTicketBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
