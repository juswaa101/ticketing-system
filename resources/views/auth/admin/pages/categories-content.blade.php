@include('cdn.jquery')
@include('cdn.datatables')
<link rel="stylesheet" href="{{ asset('css/master.css') }}">
<div class="col py-3">
    <div class="row p-3">
        <h1 class="text-justify fw-bold">Categories <button class="btn btn-success btn-md float-end" data-bs-toggle="modal"
                data-bs-target="#addCategoryModal" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Category"><i
                    class="bi bi-plus" id="add-category-modal"></i> Add
                Categories</button></h1>
    </div>
    <div class="row p-3">
        <table id="categories" class="table table-striped table-bordered table-responsive" style="width: 100%;">
        </table>
    </div>
</div>

@include('components.modals.admin.categories.add-categories-modal')
@include('components.modals.admin.categories.edit-categories-modal')

<script>
    $(function() {
        let categoriesTable = $('#categories').DataTable({
            ajax: {
                url: '/fetch-categories',
                dataType: 'json',
                dataSrc: ''
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
            "aaSorting": [
                [1, "desc"]
            ],
            columns: [{
                    data: 'category_name',
                    title: 'Category Name'
                },
                {
                    data: null,
                    title: 'Created At',
                    render: function(data) {
                        return moment(data.created_at).format('MMMM Do YYYY, h:mm:ss a');
                    }
                },
                {
                    data: null,
                    title: 'Updated At',
                    render: function(data) {
                        return moment(data.updated_at).format('MMMM Do YYYY, h:mm:ss a');
                    }
                },
                {
                    data: null,
                    title: 'Actions',
                    render: function(data) {
                        return `<button class="btn btn-primary btn-md edit-category" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Edit Category" data-val="${data.id}"><i class="fa fa-pencil">
                                </i></button>
                            <button class="btn btn-danger btn-md delete-category ${data.ticket.length > 0 ? "invisible" : "visible"}" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Delete Category" data-val="${data.id}"><i class="fa fa-trash">
                                    </i></button>`
                    }
                }
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#addCatBtn', function(e) {
            e.preventDefault();
            let addCategoryForm = $('#addCatForm')[0];
            let addCategoryFormData = new FormData(addCategoryForm);

            enableSpinner('#addCatBtn');
            $.ajax({
                type: "post",
                url: "{{ route('categories.store') }}",
                data: addCategoryFormData,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    disableSpinner('#addCatBtn', 'Save');
                    $('#addCategoryName').removeClass("is-invalid");
                    $('#addCategoryNameInvalid').html("");
                    categoriesTable.ajax.reload();
                    alert("Category Added", "Category Added Successfully", 'success');
                },
                error: function(error) {
                    disableSpinner('#addCatBtn', 'Save');
                    if (error.status === 422) {
                        if (error.responseJSON.errors.category_name[0] != null) {
                            $('#addCategoryName').addClass("is-invalid");
                            $('#addCategoryNameInvalid').html(error.responseJSON.errors
                                .category_name[0]);
                        }
                    }
                    if (error.status === 500) {
                        alert("Category Added", error.responseJSON
                            .message ??
                            "Something went wrong", 'error');
                    }
                }
            });
        });

        $(document).on('click', '.edit-category', function(e) {
            e.preventDefault();
            $('#editCategoryModal').modal('show');
            let url = "{{ route('categories.edit', ':id') }}";
            url = url.replace(':id', $(this).attr('data-val'));
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    $('#edit_cat_id').val(response.data.id);
                    $('#editCategoryName').val(response.data.category_name);
                },
                error: function(error) {
                    alert('Category Error', 'Something went wrong', 'error');
                }
            });
        });

        $(document).on('click', '.delete-category', function(e) {
            e.preventDefault();
            let url = "{{ route('categories.destroy', ':id') }}";
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
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function(response) {
                            categoriesTable.ajax.reload();
                            alert('Category Deleted',
                                'Category deleted successfully', 'success');
                        },
                        error: function(error) {
                            if (error.status === 500) {
                                alert("Category Deleted", error.responseJSON
                                    .message ??
                                    "Something went wrong", 'error');
                            }
                        }
                    });
                }
            })
        });

        $(document).on('click', '.editCatBtn', function(e) {
            e.preventDefault();
            enableSpinner('.editCatBtn');
            let editCategory = $('#editCatForm')[0];
            let editCategoryFormData = new FormData(editCategory);
            editCategoryFormData.append('_method', 'PUT');
            let url = "{{ route('categories.update', ':id') }}";
            url = url.replace(':id', $('#edit_cat_id').val());
            $.ajax({
                type: "post",
                url: url,
                data: editCategoryFormData,
                dataType: "json",
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    categoriesTable.ajax.reload();
                    $('#editCategoryName').removeClass("is-invalid");
                    $('#editCategoryNameInvalid').html("");
                    disableSpinner('.editCatBtn', 'Save');
                    alert('Category Updated', 'Category updated successfully', 'success');
                },
                error: function(error) {
                    disableSpinner('.editCatBtn', 'Save');
                    if (error.status === 422) {
                        if (error.responseJSON.errors.category_name[0] != null) {
                            $('#editCategoryName').addClass("is-invalid");
                            $('#editCategoryNameInvalid').html(error.responseJSON.errors
                                .category_name[0]);
                        }
                    }
                    if (error.status === 500) {
                        alert("Category Updated", error.responseJSON.message ??
                            "Something went wrong", 'error');
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
