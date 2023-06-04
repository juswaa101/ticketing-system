@include('cdn.jquery')
@include('cdn.datatables')
<link rel="stylesheet" href="{{ asset('css/master.css') }}">
<div class="col py-3">
    <div class="row p-3">
        <h1 class="text-justify fw-bold">Users</h1>
    </div>
    <div class="row p-3">
        <table id="users" class="table table-striped table-bordered table-responsive" style="width: 100%;">
        </table>
    </div>
</div>

@include('components.modals.admin.user.edit-user-modal')

<script>
    $(document).ready(function() {
        $('#roleSelect').select2({
            dropdownParent: $('#editUserModal'),
            ajax: {
                url: '/fetch-roles',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(term) {
                    return {
                        term: term
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.role_name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: false
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            placeholder: 'Select a role',
            maximumSelectionLength: 3,
            templateResult: formatRole,
        });

        function formatRole(role) {
            if (role.id) {
                return role.text;
            }

            var data = $(
                '<span>' + role.text + '</span>'
            )

            return data;
        }

        let usersTable = $('#users').DataTable({
            ajax: {
                url: '/fetch-users',
                dataType: 'json',
                dataSrc: ""
            },
            "aaSorting": [
                [0, "asc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
            columns: [{
                    data: 'name',
                    title: 'Name'
                },
                {
                    data: 'email',
                    title: 'Email',
                },
                {
                    data: null,
                    title: 'Role',
                    render: function(data) {
                        return data.roles.length > 0 ? data.roles.map(e =>
                                `<span class="badge rounded-pill text-bg-warning">${e.role_name.toUpperCase()}</span>`
                            ).join(' ') :
                            `<span class="badge rounded-pill text-bg-secondary">No Assigned Role Yet</span>`;
                    }
                },
                {
                    data: null,
                    render: function(data) {
                        console.log(data);
                        return `
                        <button class="btn btn-primary btn-md edit-user" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Edit User" data-val="${data.id}"><i class="fa fa-pencil">
                                    </i></button>
                            <button class="btn btn-danger btn-md delete-user ${data.roles.length > 0 || data.owned_tickets.length > 0 ? "invisible" : "visible"} data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete User" data-val="${data.id}"><i class="fa fa-trash">
                                    </i></button>
                        `;
                    },
                    title: 'Action'
                }
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.edit-user', function(e) {
            e.preventDefault();
            $('#editUserModal').modal('show');
            let url = "{{ route('users.edit', ':id') }}";
            url = url.replace(':id', $(this).attr('data-val'));
            $('#roleSelect').html("").trigger('change');
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    response.data.roles.forEach((e) => {
                        var option = new Option(e.role_name,
                            e.id, true, true);
                        $('#roleSelect').append(option).trigger('change');
                    });
                    $('#edit_id').val(response.data.id);
                    $('#edit_name').val(response.data.name);
                    $('#edit_email').val(response.data.email);
                },
                error: function(error) {
                    alert('User Error', 'Something went wrong', 'error');
                }
            });
        });

        $(document).on('click', '.delete-user', function(e) {
            e.preventDefault();
            let url = "{{ route('users.destroy', ':id') }}";
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
                            alert("User Deleted", "User Deleted Successfully",
                                "success");
                            usersTable.ajax.reload();
                        },
                        error: function(error) {
                            if (error.status === 500) {
                                alert('User Error', error.responseJSON.message ??
                                    'Something went wrong',
                                    'error');
                            }
                        }
                    });
                }
            })
        });

        $(document).on('click', '.editUserBtn', function(e) {
            e.preventDefault();
            let editUser = $('#editUserForm')[0];
            let editUserFormData = new FormData(editUser);
            editUserFormData.append('_method', 'PUT');
            let url = "{{ route('users.update', ':id') }}";
            url = url.replace(':id', $('#edit_id').val());

            enableSpinner('.editUserBtn');
            $.ajax({
                type: "post",
                url: url,
                data: editUserFormData,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    $('#edit_name').removeClass('is-invalid');
                    $('#editNameInvalid').html("");
                    $('#edit_email').removeClass('is-invalid');
                    $('#editEmailInvalid').html("");
                    $('#roleSelect').removeClass("is-invalid");
                    $('#editRolesInvalid').html("");
                    disableSpinner('.editUserBtn', 'Save');
                    usersTable.ajax.reload();
                    alert('User Updated', 'User Updated Successfully!', 'success');
                },
                error: function(error) {
                    disableSpinner('.editUserBtn', 'Save');
                    if (error.status === 422) {
                        if (error.responseJSON.errors.name != null) {
                            $('#edit_name').addClass('is-invalid');
                            $('#editNameInvalid').html(error.responseJSON.errors.name[0]);
                        }
                        if (error.responseJSON.errors.email != null) {
                            $('#edit_email').addClass('is-invalid');
                            $('#editEmailInvalid').html(error.responseJSON.errors.email[0]);
                        }
                        if (error.responseJSON.errors.roles != null) {
                            $('#roleSelect').addClass("is-invalid");
                            $('#editRolesInvalid').html(error.responseJSON.errors.roles[0]);
                        }
                    }

                    if (error.status === 500) {
                        alert('User Error', error.responseJSON.message ??
                            'Something went wrong',
                            'error');
                    }
                }
            });
        });

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
