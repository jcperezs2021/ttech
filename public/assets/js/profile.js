$(document).ready(function() {

    // Update Password
    $('#updatePassword').on('submit', function(e) {
        e.preventDefault();

        const oldPassword   = $('#oldPassword').val();
        const password      = $('#password').val();
        const password_confirmation = $('#password_confirmation').val();

        // Validar que password tenga al menos 6 caracteres
        if (password.length < 6) {
            showMessage('alert-danger', 'La nueva contraseña debe tener al menos 6 caracteres.');
            return;
        }

        // Validar si las contraseñas coinciden
        if (password !== password_confirmation) {
            showMessage('alert-danger', 'Las nuevas contraseñas no coinciden.');
            return;
        }
        
        // Enviar solicitud
        $.post(baseUrl + `/password`, { [csrfName]: csrfHash, oldPassword, password, password_confirmation }, handleResponse)
          .fail(() => showMessage('alert-danger', 'Error en la solicitud.'))
          .done(() => {
            $('#oldPassword').val('');
            $('#password').val('');
            $('#password_confirmation').val('');
          });
    });

    $('#photo').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#actualImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    // Update Photo
    $('#updatePhoto').on('submit', function(e) {
        e.preventDefault();
        const photo = $('#photo').prop('files')[0];
        const formData = new FormData();
        formData.append('photo', photo);
        formData.append(csrfName, csrfHash);
        $.ajax({
            url: baseUrl + '/photo',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: handleResponse,
            error: () => showMessage('alert-danger', 'Error en la solicitud.')
        });
    });
});