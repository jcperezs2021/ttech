$(document).ready(function() {
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