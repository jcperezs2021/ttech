$(document).ready(function() {
  // Inicializar DataTable
  $('#dt_organigramas').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
    },
    order: [[3, 'desc']]
  });
});