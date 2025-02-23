$(document).ready(function() {

   

    // Inicializa FilePond
    FilePond.create(document.getElementById('file'), {
        credits: false, 
        acceptedFileTypes: ['image/*'],
        server: {
            url: base_url + '/files',
            process: {
                url: '/upload',
                method: 'POST',
                headers: {
                    'x-customheader': 'Hello World',
                },
                withCredentials: false,
                onload: (response) => response.key,
                onerror: (response) => response.data,
                ondata: (formData) => {
                    formData.append('Hello', 'World');
                    return formData;
                },
            },
            revert: '/revert' 
        }
    });

    // Opciones de FilePond
    FilePond.setOptions({
        labelIdle: 'Arrastra y suelta tus archivos o <span class="filepond--label-action">Explorar</span>',
        labelFileLoading: 'Cargando...',
        labelFileProcessing: 'Subiendo...',
        labelFileProcessingComplete: 'Subida completa',
        labelFileProcessingError: 'Error al subir el archivo',
        labelFileRemoveError: 'Error al eliminar',
        labelTapToCancel: 'Pulsa para cancelar',
        labelTapToRetry: 'Pulsa para reintentar',
        labelTapToUndo: 'Pulsa para deshacer',
        labelFileTypeNotAllowed: 'Tipo de archivo no permitido',
    });
});

