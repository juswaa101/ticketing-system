@include('cdn.jquery')
@include('cdn.datatables')
<link rel="stylesheet" href="{{ asset('css/master.css') }}">
<div class="col py-3">
    <div class="row p-3">
        <h1 class="text-justify fw-bold">Roles <button class="btn btn-success btn-md float-end" type="button"
                data-bs-toggle="modal" data-bs-target="#addRoleModal"><i class="bi bi-plus" id="add-role-modal"></i> Add
                Roles</button></h1>
    </div>
    <div class="row p-3">
        <table id="roles" class="table table-striped table-bordered table-responsive" style="width: 100%;">
        </table>
    </div>
</div>

@include('components.modals.admin.roles.add-roles-modal')
@include('components.modals.admin.roles.edit-roles-modal')

<script>
    $(function() {
        let rolesTable = $('#roles').DataTable({
            ajax: {
                url: "/fetch-roles",
                dataType: "json",
                dataSrc: ""
            },
            "aaSorting": [
                [1, "desc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
            columns: [{
                    data: 'role_name',
                    title: 'Role Name'
                },
                {
                    data: 'created_at',
                    title: 'Created At',
                    render: function(data) {
                        return moment(data.created_at).format('MMMM Do YYYY, h:mm:ss a');
                    }
                },
                {
                    data: 'updated_at',
                    title: "Updated At",
                    render: function(data) {
                        return moment(data.updated_at).format('MMMM Do YYYY, h:mm:ss a');
                    }
                },
                {
                    data: null,
                    render: function(data) {
                        console.log(data);
                        return `
                        <button class="btn btn-primary btn-md edit-role" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Edit Role" data-val="${data.id}"><i class="fa fa-pencil">
                                </i></button>
                            <button class="btn btn-danger btn-md delete-role ${data.users.length > 0 || data.tickets.length > 0 ? "invisible" : "visible"}" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete Role" data-val="${data.id}"><i class="fa fa-trash">
                                    </i></button>
                        `;
                    },
                    title: 'Action'
                }
            ]
        });

        $('[data-bs-toggle="tooltip"]').tooltip();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#addRoleBtn', function(e) {
            e.preventDefault();
            let addRoleForm = $('#addRoleForm')[0];
            let addRoleFormData = new FormData(addRoleForm);
            ajax(
                "post",
                "{{ route('roles.store') }}",
                addRoleFormData,
                'Role Added',
                'Role Error',
                '#addRoleBtn',
                'Save',
                "Add Role Success",
                "Something went wrong",
                "#addRoleName",
                "#addRoleNameInvalid"
            );
        });

        $(document).on('click', '.edit-role', function(e) {
            e.preventDefault();
            $('#editRoleModal').modal('show');
            let url = "{{ route('roles.edit', ':id') }}";
            url = url.replace(':id', $(this).attr('data-val'));
            ajax(
                "get",
                url,
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                ''
            );
        });

        $(document).on('click', '.delete-role', function(e) {
            e.preventDefault();
            let url = "{{ route('roles.destroy', ':id') }}";
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
                    ajax(
                        "delete",
                        url,
                        "",
                        "",
                        "",
                        "",
                        "",
                        "Role Deleted Successfully",
                        "Role Not Deleted Successfully"
                    );
                }
            })
        });

        $(document).on('click', '.editRoleBtn', function(e) {
            e.preventDefault();
            let editRole = $('#editRoleForm')[0];
            let editRoleFormData = new FormData(editRole);
            editRoleFormData.append('_method', 'PUT');
            let url = "{{ route('roles.update', ':id') }}";
            url = url.replace(':id', $('#role_id').val());
            ajax(
                "post",
                url,
                editRoleFormData,
                "Role",
                "Role Error",
                ".editRoleBtn",
                "Save",
                "Role Updated Successfully",
                "Something went wrong",
                "#editRoleName",
                "#editRoleNameInvalid"
            );
        });

        function ajax(
            methodType,
            url,
            data = "",
            title = "",
            titleError = "",
            element = "",
            btnText = "",
            successMessage = "",
            errorMessage = "",
            validationName = "",
            validationLabel = "",
        ) {
            enableSpinner(element);
            $(validationName).removeClass('is-invalid');
            $(validationLabel).html("");
            $.ajax({
                type: methodType,
                url: url,
                data: data,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    $(validationName).removeClass('is-invalid');
                    $(validationLabel).html("");
                    disableSpinner(element, btnText);
                    if (response.data.length != 0) {
                        $('#role_id').val(response.data.id);
                        $('#editRoleName').val(response.data.role_name);
                    } else {
                        rolesTable.ajax.reload();
                        alert(title, successMessage, 'success');
                    }
                },
                error: (error, xhs, code) => {
                    disableSpinner(element, btnText);
                    if (error.status === 422) {
                        if (error.responseJSON.errors.role_name != null) {
                            $(validationName).addClass('is-invalid');
                            $(validationLabel).html(error.responseJSON.errors.role_name[0]);
                        }
                    }
                    if (error.status === 500) {
                        alert(titleError, error.responseJSON.message ?? errorMessage, 'error');
                    }
                }
            });
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
    });
</script>
