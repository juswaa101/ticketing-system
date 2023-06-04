@include('cdn.select2')

<!-- Modal -->
<div class="modal fade" id="editUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm">
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="edit_name" name="name">
                        <label for="floatingInput">Full Name</label>
                        <span class="invalid-feedback" id="editNameInvalid"></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="edit_email" name="email">
                        <label for="floatingInput">Email address</label>
                        <span class="invalid-feedback" id="editEmailInvalid"></span>
                    </div>
                    <div class="mb-3">
                        <label for="floatingInput">Roles</label><br />
                        <select class="form-control" id="roleSelect" name="roles[]" style="width: 100%;" multiple>
                        </select>
                        <span class="invalid-feedback" id="editRolesInvalid"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary editUserBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
