function showMessage(alertClass, message) {

  var style = {  background: "linear-gradient(to right, #00b09b, #96c93d)" };
  
  if(alertClass === 'alert-info'){
    style = { background: "#1E90FF" };
  }
  if(alertClass === 'alert-success'){
    style = { background: "#00b09b" };
  }
  if(alertClass === 'alert-danger'){
    style = {  background: "linear-gradient(to right, #f85032, #e73827)" };
  }
  if(alertClass === 'alert-warning'){
    style = { background: "#FF8C00" };
  }

  Toastify({
    text: message,
    duration: 5000,
    close: true,
    gravity: "top",
    position: "right",
    stopOnFocus: true,
    style: style
  }).showToast();
}

function hideMessage() {
  $('#message__response').hide();
}

function actualizarCsrfToken(csrfNameNuevo, csrfHashNuevo) {
    csrfName = csrfNameNuevo;
    csrfHash = csrfHashNuevo;
    $('meta[name="csrf-token-name"]').attr('content', csrfName);
    $('meta[name="csrf-token"]').attr('content', csrfHash);
    $('input[name="' + csrfNameNuevo + '"]').val(csrfHashNuevo);
}

function actualizarCsrfTokenAjax(csrfNameNuevo, csrfHashNuevo) {
    csrfName = csrfNameNuevo;
    csrfHash = csrfHashNuevo;
}

// Remove item
$(document).on('click', '.removeItem', function() {
    let itemId = $(this).attr('itemId');
    let deleteItem = confirm('¿Estás seguro de que deseas eliminar este elemento, este cambio no puede revertirse?');
    if (deleteItem) {
        $.post(deleteURL, { id: itemId, [csrfName]: csrfHash }, handleResponse)
          .fail(() => showMessage('alert-danger', 'Error en la solicitud.'))
          .done(() => { $(this).closest('tr').remove(); });

    }
});

function handleResponseWithReload(resp) {
  try {
    if (resp.ok) {
      window.location.reload();
    } else {
      showMessage('alert-danger', resp.error);
      $('.modal').modal('hide');
    }
    if (resp.csrf_name && resp.csrf_token) {
      actualizarCsrfTokenAjax(resp.csrf_name, resp.csrf_token);
    }
  } catch (e) {
    showMessage('alert-danger', 'Error en el procesamiento de la respuesta.');
  }
}

function handleResponse(resp) {
  try {
    if (resp.ok) {
      let message = resp.message || 'Actualizado correctamente';
      showMessage('alert-success', message);
    } else {
      showMessage('alert-danger', resp.error);
      $('.modal').modal('hide');
    }
    if (resp.csrf_name && resp.csrf_token) {
      actualizarCsrfTokenAjax(resp.csrf_name, resp.csrf_token);
    }
  } catch (e) {
    showMessage('alert-danger', 'Error en el procesamiento de la respuesta.');
  }
}

