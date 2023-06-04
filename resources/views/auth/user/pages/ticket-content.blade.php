@include('cdn.jquery')
@include('cdn.datatables')
<link rel="stylesheet" href="{{ asset('css/master.css') }}">
<div class="col py-3">
    <div class="row p-3">
        <h1 class="text-justify fw-bold">Tickets <button class="btn btn-success btn-md float-end" data-bs-toggle="modal"
                data-bs-target="#addTicketModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Add a ticket"><i
                    class="bi bi-plus" id="add-ticket-modal"></i> Add
                Ticket</button></h1>
    </div>
    <div class="row p-3">
        <table id="tickets" class="table table-striped table-bordered table-responsive" style="width: 100%;">
        </table>
    </div>
</div>

@include('components.modals.users.tickets.add-ticket-modal')
@include('components.modals.users.tickets.edit-ticket-modal')
@include('components.modals.users.tickets.view-ticket-modal')
@include('components.modals.users.comments.view-comments')

<script>
    $(function() {
        let ticketsTable = $('#tickets').DataTable({
            ajax: {
                url: '/fetch-user-tickets',
                dataType: 'json',
                dataSrc: ''
            },
            "aaSorting": [
                [0, "asc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
            columns: [{
                    data: null,
                    title: 'Request By',
                    render: function(data) {
                        return data.owner.id == `{{ auth()->user()->id }}` ?
                            `<span class="badge rounded-pill bg-success">Me</span>` :
                            `<span class="badge rounded-pill bg-secondary">${data.owner.name}</span>`;
                    }
                },
                {
                    data: 'title',
                    title: 'Title'
                },
                {
                    data: 'message',
                    title: 'Message'
                },
                {
                    data: null,
                    title: 'Priority',
                    render: function(data) {
                        return `<span
                                class="badge rounded-pill ${data.priority == 0 ? 'bg-secondary' : (data.priority == 1 ? 'bg-warning text-dark' : 'bg-danger') }">
                                ${data.priority == 0 ? 'Low' : (data.priority == 1 ? 'Mid' : 'High')}</span>`;
                    }
                },
                {
                    data: null,
                    title: 'To Department',
                    render: function(data) {
                        return `${data.department.role_name}`;
                    }
                },
                {
                    data: null,
                    title: 'Category',
                    render: function(data) {
                        return `${data.category.category_name}`;
                    }
                },
                {
                    data: null,
                    title: 'Status',
                    render: function(data) {
                        return `<span
                                class="badge rounded-pill  ${data.status.status == 0 ? 'bg-danger' : (data.status.status == 1 ? 'bg-warning text-dark' : 'bg-success') }">
                                ${data.status.status == 0 ? 'Pending' : (data.status.status == 1 ? 'On Going' : 'Solved') }</span>`;
                    }
                },
                {
                    data: null,
                    title: 'Actions',
                    render: function(data) {
                        return `<td><button class="btn btn-secondary btn view-ticket mt-2" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="View Ticket" data-val="${data.id}"><i class="fa fa-eye"></i></button></td>
                                <td><button class="btn btn-primary btn mt-2 edit-ticket" title="Edit Ticket"
                                    data-bs-placement="top"
                                    data-bs-toggle="tooltip"
                                    data-val="${data.id}"
                                ><i class="fa fa-pencil"></i></button>
                                <button class="btn btn-warning btn comment-ticket mt-2" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="View Comment" data-val="${data.id}"><i class="fa fa-comment"></i></button>
                                <button class="btn btn-danger delete-ticket mt-2 ${data.owner.id != {{ auth()->user()->id }} ? "invisible" : "visible"}" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete Ticket" data-val="${data.id}"><i class="fa fa-trash"></i></button>
                                </td>`
                    }
                },
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        initializedDropdown();

        function initializedDropdown() {
            loadCategories().then((data) => {
                $.each(data, function(key, value) {
                    $('#addCategory').append(
                        `<option value=${value.id}>${value.category_name}</option>`);
                    $('#editCategory').append(
                        `<option value=${value.id}>${value.category_name}</option>`);
                });
            }).catch((error) => {
                alert('Error', 'Something went wrong', 'error');
            });

            loadDepartments().then((data) => {
                $.each(data, function(key, value) {
                    $('#addDepartment').append(
                        `<option value=${value.id}>${value.role_name}</option>`);
                    $('#editDepartment').append(
                        `<option value=${value.id}>${value.role_name}</option>`);
                });
            }).catch((error) => {
                alert('Error', 'Something went wrong', 'error');
            })
        };

        async function loadCategories() {
            const result = await $.ajax({
                type: "get",
                url: "/fetch-user-categories",
                dataType: "json",
            });
            return result;
        }

        async function loadDepartments() {
            const result = await $.ajax({
                type: "get",
                url: "/fetch-user-roles",
                dataType: "json",
            });
            return result;
        }

        $(document).on('click', '#addTicketBtn', function(e) {
            e.preventDefault();
            enableSpinner('#addTicketBtn');
            let ticketForm = $('#addTicketForm')[0];
            let ticketFormData = new FormData(ticketForm);
            $.ajax({
                type: "post",
                url: "{{ route('user-tickets.store') }}",
                data: ticketFormData,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    clearAddValidation();
                    disableSpinner('#addTicketBtn', 'Save');
                    ticketsTable.ajax.reload();
                    alert('Ticket Added', 'Ticket added successfully', 'success');
                },
                error: function(error) {
                    disableSpinner('#addTicketBtn', 'Save');
                    if (error.status === 422) {
                        if (typeof error.responseJSON.errors.title != "undefined" || error
                            .responseJSON.errors.title != null) {
                            $('#addTitle').addClass("is-invalid");
                            $('#addTitleInvalid').html(error.responseJSON.errors.title[0]);
                        }

                        if (typeof error.responseJSON.errors.message != "undefined" || error
                            .responseJSON.errors.message != null) {
                            $('#addMessage').addClass("is-invalid");
                            $('#addMessageInvalid').html(error.responseJSON.errors.message[
                                0]);
                        }
                        if (typeof error.responseJSON.errors.department != "undefined" ||
                            error.responseJSON.errors.department != null) {
                            $('#addDepartment').addClass("is-invalid");
                            $('#addDepartmentInvalid').html(error.responseJSON.errors
                                .department[0]);
                        }

                        if (typeof error.responseJSON.errors.category != "undefined" ||
                            error.responseJSON.errors.category != null) {
                            $('#addCategory').addClass("is-invalid");
                            $('#addCategoryInvalid').html(error.responseJSON.errors
                                .category[0]);
                        }

                        if (typeof error.responseJSON.errors.priority != "undefined" ||
                            error.responseJSON.errors.priority != null) {
                            $('#addPriority').addClass("is-invalid");
                            $('#addPriorityInvalid').html(error.responseJSON.errors
                                .priority[0]);
                        }
                    }
                    if (error.status === 500) {
                        alert(
                            "Ticket Error", error.responseJSON.message ??
                            "Something went wrong",
                            'error'
                        );
                    }
                }
            });
        });

        $(document).on('click', '.edit-ticket', function(e) {
            e.preventDefault();
            $('#editTicketModal').modal('show');
            let url = "{{ route('user-tickets.edit', ':id') }}";
            url = url.replace(':id', $(this).attr('data-val'));
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    $('#editTicketId').val(response.data.id);
                    $('#editTitle').val(response.data.title);
                    $('#editMessage').val(response.data.message);
                    $('#editDepartment').val(response.data.department.id);
                    $('#editCategory').val(response.data.category.id);
                    $('#editPriority').val(response.data.priority);
                    $('#editStatus').val(response.data.status.status);
                },
                error: function(error) {
                    alert("Ticket Error", "Something went wrong", "error");
                }
            });
        });

        $(document).on('click', '.editTicketBtn', function(e) {
            enableSpinner('.editTicketBtn');
            let ticketForm = $('#editTicketForm')[0];
            let ticketFormData = new FormData(ticketForm);
            ticketFormData.append('_method', 'PUT');

            let url = "{{ route('user-tickets.update', ':id') }}";
            url = url.replace(':id', $('#editTicketId').val());
            $.ajax({
                type: "post",
                url: url,
                data: ticketFormData,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    disableSpinner('.editTicketBtn', 'Save');
                    alert("Ticket Updated", "Ticket Updated Successfully", "success");
                    clearEditValidation();
                    ticketsTable.ajax.reload();
                },
                error: function(error) {
                    disableSpinner('.editTicketBtn', 'Save');
                    if (error.status === 422) {
                        if (typeof error.responseJSON.errors.title != "undefined" || error
                            .responseJSON.errors.title != null) {
                            $('#editTitle').addClass("is-invalid");
                            $('#editTitleInvalid').html(error.responseJSON.errors.title[0]);
                        }

                        if (typeof error.responseJSON.errors.message != "undefined" || error
                            .responseJSON.errors.message != null) {
                            $('#editMessage').addClass("is-invalid");
                            $('#editMessageInvalid').html(error.responseJSON.errors.message[
                                0]);
                        }
                        if (typeof error.responseJSON.errors.department != "undefined" ||
                            error.responseJSON.errors.department != null) {
                            $('#editDepartment').addClass("is-invalid");
                            $('#editDepartmentInvalid').html(error.responseJSON.errors
                                .department[0]);
                        }

                        if (typeof error.responseJSON.errors.category != "undefined" ||
                            error.responseJSON.errors.category != null) {
                            $('#editCategory').addClass("is-invalid");
                            $('#editCategoryInvalid').html(error.responseJSON.errors
                                .category[0]);
                        }

                        if (typeof error.responseJSON.errors.priority != "undefined" ||
                            error.responseJSON.errors.priority != null) {
                            $('#editPriority').addClass("is-invalid");
                            $('#editPriorityInvalid').html(error.responseJSON.errors
                                .priority[0]);
                        }

                        if (typeof error.responseJSON.errors.status != "undefined" ||
                            error.responseJSON.errors.status != null) {
                            $('#editStatus').addClass("is-invalid");
                            $('#editStatusInvalid').html(error.responseJSON.errors
                                .status[0]);
                        }
                    }
                    if (error.status === 500) {
                        alert(
                            "Ticket Error", error.responseJSON.message ??
                            "Something went wrong",
                            'error'
                        );
                    }
                }
            });
        });

        $(document).on('click', '.view-ticket', function(e) {
            $('#viewTicketModal').modal('show');
            let url = "{{ route('user-tickets.show', ':id') }}";
            url = url.replace(':id', $(this).attr('data-val'));
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    $('#ticketTitle').html(response.data.title);
                    $('#viewTicketBody').html(`
                        <label class="form-label">Owner:</label>
                        <p class="text-muted">${response.data.owner.name}</p>
                        <label class="form-label">Ticket Message:</label>
                        <p class="text-muted">${response.data.message}</p>
                        <label class="form-label">Assigned Department:</label>
                        <p class="text-muted">${response.data.department.role_name}</p>
                        <label class="form-label">Ticket Category:</label>
                        <p class="text-muted">${response.data.category.category_name}</p>
                        <label class="form-label">Ticket Status:</label>
                        <span class="badge rounded-pill  ${response.data.status.status == 0 ? 'bg-danger' : (response.data.status.status == 1 ? 'bg-warning text-dark' : 'bg-success') }">
                            ${response.data.status.status == 0 ? 'Pending' : (response.data.status.status == 1 ? 'On Going' : 'Solved') }</span><br/>
                        <label class="form-label">Ticket Priority:</label>
                        <span class="badge rounded-pill ${response.data.priority == 0 ? 'bg-secondary' : (response.data.priority == 1 ? 'bg-warning text-dark' : 'bg-danger') }">
                            ${response.data.priority == 0 ? 'Low' : (response.data.priority == 1 ? 'Mid' : 'High')}</span><br/>
                    `);
                },
                error: function(error) {
                    alert("Ticket Error", "Something went wrong!", "error");
                }
            });
        });

        $(document).on('click', '.comment-ticket', function(e) {
            $('#viewCommentModal').modal('show');
            let url = "{{ route('comments.show', ':id') }}";
            url = url.replace(':id', $(this).attr('data-val'));
            $('#ticketId').val($(this).attr('data-val'));
            $('#commentBody').html("");
            reloadComments(url);
        });

        $(document).on('click', '#postComment', function(e) {
            let addCommentForm = $('#addCommentForm')[0];
            let addCommentFormData = new FormData(addCommentForm);
            enableSpinner("#postComment");
            $.ajax({
                type: "post",
                url: "{{ route('comments.store') }}",
                data: addCommentFormData,
                dataType: "json",
                processData: false,
                cache: false,
                contentType: false,
                success: function(response) {
                    disableSpinner("#postComment", "Post Comment");
                    let url = "{{ route('comments.show', ':id') }}";
                    url = url.replace(':id', $('#ticketId').val());
                    console.log(url);
                    $("#commentArea").removeClass("is-invalid");
                    $('#commentAreaError').html("");
                    $('#commentBody').html("");
                    $("#commentArea").val("");
                    reloadComments(url);
                },
                error: function(error) {
                    disableSpinner("#postComment", "Post Comment");
                    if (error.status === 422) {
                        $("#commentArea").addClass("is-invalid");
                        $('#commentAreaError').html(error.responseJSON.errors.comment[0]);
                    }

                    if (error.status === 500) {
                        alert("Comment Error", "Something went wrong", "error");
                    }
                }
            });
        });

        $(document).on('click', '.delete-ticket', function(e) {
            let url = "{{ route('user-tickets.destroy', ':id') }}";
            url = url.replace(':id', $(this).attr('data-val'));
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: url,
                        dataType: "json",
                        success: function(response) {
                            ticketsTable.ajax.reload();
                            alert("Ticket Deleted", "Ticket Deleted Successfully",
                                "success");
                        },
                        error: function(error) {
                            console.log(error);
                            if (error.status === 500) {
                                alert("Ticket Error", error.responseJSON.message ??
                                    "Something Went Wrong",
                                    "error");
                            }
                        }
                    });
                }
            })
        });

        async function reloadComments(url) {
            $('#commentBody').html(`
                <div class="d-flex justify-content-center p-5">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);
            await $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    $('#commentBody').html("");
                    if (response.data.length > 0) {
                        $.each(response.data, function(index, value) {
                            $('#commentBody').append(`
                            <div class="col-md-12 mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-start align-items-center">
                                            <img class="rounded-circle shadow-1-strong me-3"
                                                src="https://ui-avatars.com/api/?name=${value.user.name}&background=0D8ABC&color=fff"
                                                alt="avatar" width="60" height="60" />
                                            <div>
                                                <h6 class="fw-bold text-primary mb-1">${value.user.name}</h6>
                                                <p class="text-muted small mb-0">
                                                    ${moment(value.created_at).format('MMMM Do YYYY, h:mm:ss a')}
                                                </p>
                                            </div>
                                        </div>

                                        <p class="mt-3 mb-4 pb-2">${value.comment}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        });
                    } else {
                        $('#commentBody').append(`
                            <div class="d-flex justify-content-center align-items-center p-5">
                                <h1 class="text-center">No Comments Yet</h1>
                            </div>`);
                    }
                },
                error: function(error) {
                    alert("Comment Error", "Something went wrong!", "error");
                }
            });
        }

        function clearAddValidation() {
            $('#addTitle').removeClass("is-invalid");
            $('#addTitleInvalid').html("");
            $('#addMessage').removeClass("is-invalid");
            $('#addMessageInvalid').html("");
            $('#addDepartment').removeClass("is-invalid");
            $('#addDepartmentInvalid').html("");
            $('#addCategory').removeClass("is-invalid");
            $('#addCategoryInvalid').html("");
            $('#addPriority').removeClass("is-invalid");
            $('#addPriorityInvalid').html("");
        }

        function clearEditValidation() {
            $('#editTitle').removeClass("is-invalid");
            $('#editTitleInvalid').html("");
            $('#editMessage').removeClass("is-invalid");
            $('#editMessageInvalid').html("");
            $('#editDepartment').removeClass("is-invalid");
            $('#editDepartmentInvalid').html("");
            $('#editCategory').removeClass("is-invalid");
            $('#editCategoryInvalid').html("");
            $('#editPriority').removeClass("is-invalid");
            $('#editPriorityInvalid').html("");
            $('#editStatus').removeClass("is-invalid");
            $('#editStatusInvalid').html("");
        }

        function alert(title, message, type) {
            new swal({
                title: title,
                text: message,
                icon: type,
            });
        }

        function enableSpinner(element) {
            $(element).prop('disabled', true);
            $(element).html("<i class='fa fa-spinner fa-spin'></i> Loading");
        }

        function disableSpinner(element, text) {
            $(element).prop('disabled', false);
            $(element).html(text);
        }
        $('[data-bs-toggle="tooltip"]').tooltip()
    });
</script>
