$(document).ready(function() {
  // Inicializar DataTable solo si la tabla tiene filas de datos
  const $table = $('#dt_organigramas');
  if ($table.length && $table.find('tbody tr').length > 0 && !$table.find('tbody tr td[colspan]').length) {
    $table.DataTable({
      order: [[2, 'desc']], // Ordenar por fecha de creación descendente
      language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'}
    });
  }
});