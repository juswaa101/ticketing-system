<!-- Modal -->
<div class="modal fade" id="editCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCatForm">
                <div class="modal-body">
                    <input type="hidden" name="cat_id" id="edit_cat_id">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="editCategoryName" name="category_name"
                            placeholder="eg. Tech Issue">
                        <label for="floatingInput">Category Name</label>
                        <span class="invalid-feedback" id="editCategoryNameInvalid"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary editCatBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
