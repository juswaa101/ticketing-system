@include('cdn.jquery')
@include('cdn.datatables')
<link rel="stylesheet" href="{{ asset('css/master.css') }}">
<div class="col py-3">
    <div class="row p-3">
        <h1 class="text-justify fw-bold">Logs</h1>
    </div>
    <div class="row p-3">
        <table id="logs" class="table table-striped table-bordered table-responsive" style="width: 100%;">
        </table>
    </div>
</div>

<script>
    $(function() {
        let rolesTable = $('#logs').DataTable({
            ajax: {
                url: '/admin-render-logs',
                dataType: 'json',
                dataSrc: '',
            },
            "aaSorting": [
                [2, "desc"]
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ],
            columns: [{
                    data: null,
                    title: 'Ticket Title',
                    render: function(data) {
                        return data.ticket.title;
                    }
                },
                {
                    data: null,
                    title: 'Action Made',
                    render: function(data){
                        console.log(data);
                        return data.user.name + data.action_made
                    }
                },
                {
                    data: null,
                    title: 'Updated At',
                    render: function(data) {
                        return moment(data.ticket.updated_at).format('MMMM Do YYYY, h:mm:ss a');
                    }
                }
            ]
        });
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
