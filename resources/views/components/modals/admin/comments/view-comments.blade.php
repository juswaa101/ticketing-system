<!-- Modal -->
<div class="modal fade" id="viewCommentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ticketTitle">View Comment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="commentBody">
            </div>
            <form id="addCommentForm">
                <input type="hidden" name="ticketId" id="ticketId">
                <div class="modal-footer">
                    <div class="d-flex flex-start w-100">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D8ABC&color=fff"
                            alt="hugenerd" width="40" height="40" class="rounded-circle shadow-1-strong me-3">
                        <div class="form-outline w-100">
                            <textarea class="form-control" name="comment" id="commentArea" rows="4" style="background: #fff; resize: none;"
                                placeholder="Place your comment here"></textarea>
                        </div>
                    </div>
                    <div class="invalid-feedback d-block" style="margin-left: 55px;" id="commentAreaError"></div>
                    <div class="float-end mt-2 pt-1">
                        <button type="button" class="btn btn-primary btn-sm" id="postComment">Post comment</button>
                        <button type="button" class="btn btn-outline-primary btn-sm"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
