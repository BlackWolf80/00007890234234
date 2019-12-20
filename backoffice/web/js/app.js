$(function () {
    $('.data_table').DataTable({
        "paging": true,
        "pagingType": "numbers",
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "stateSave": true,
        "language": {
            "info": "Показана страница _PAGE_ из _PAGES_",
            "previous": "Предыдущая",
            "next": "Следующая"
        }
    });
});