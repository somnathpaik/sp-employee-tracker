$(document).ready(function () {
    var resource_summary_table = $('#resource_summary_table').DataTable({
        "pageLength": 10,
        responsive: true,
        "lengthChange": false,

    });
    $("#resource_summary_input").on("keyup", function () {
        resource_summary_table.search(this.value).draw();

    });

    var oTable = $('#client_summary').DataTable({
        "pageLength": 10,
        responsive: true,
        "lengthChange": false,

    });
    $("#serach_client").on("keyup", function () {
        oTable.search(this.value).draw();

    });
    if ($('.date_time_picker').length > 0) {
        $('.date_time_picker').datetimepicker({
            format:'Y-m-d H:i:s',
            timepicker:true,
            defaultTime:false,

        });
    }
});