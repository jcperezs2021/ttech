$(document).ready(function() {
    let table = new DataTable('#dt_table', {
        responsive: {
            details: false
        },
        order: [[0, 'desc']],
        pageLength: 10,
        language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'},
        dom: "Bfrtip",
        buttons: ['csv', 'excel']
    });

    let tableDirectory = new DataTable('#dt_table_directory', {
        responsive: {
            details: false
        },
        order: [[0, 'asc']],
        pageLength: 10,
        language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'},
        dom: "Bfrtip",
        buttons: ['csv', 'excel']
    });
});