<!-- Modal -->
<div class="modal fade" id="addTicketModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Ticket</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addTicketForm">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="addTitle" name="title"
                            placeholder="name@example.com">
                        <label for="floatingInput">Title</label>
                        <span class="invalid-feedback" id="addTitleInvalid"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" name="message" id="addMessage" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Message</label>
                        <span class="invalid-feedback" id="addMessageInvalid"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="addDepartment" name="department">
                            <option value="">Select a Department</option>
                        </select>
                        <label for="floatingSelect">Department</label>
                        <span class="invalid-feedback" id="addDepartmentInvalid"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="addCategory" name="category">
                            <option value="">Select a Ticket Category</option>
                        </select>
                        <label for="floatingSelect">Ticket Category</label>
                        <span class="invalid-feedback" id="addCategoryInvalid"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="addPriority" name="priority">
                            <option value="">Select a Priority</option>
                            <option value="0">Low</option>
                            <option value="1">Mid</option>
                            <option value="2">High</option>
                        </select>
                        <label for="floatingSelect">Priority</label>
                        <span class="invalid-feedback" id="addPriorityInvalid"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addTicketBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
