<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Administrar Documentos</h5>
      <div class="row">
        <div class="col-12">
          <form method="post" class="py-4" action="<?= base_url('document/new') ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Nuevo Tipo</label>
                  <input 
                    type="text" 
                    id="folder" 
                    name="folder" 
                    class="form-control" 
                    required=""
                  >
                </div>
              </div>
              <div class="col d-flex align-items-center">
                <button type="submit" class="btn btn-outline-primary d-block">Crear tipo</button>
              </div>
            </div>
            <?php if (session('message') !== null) : ?>
              <div class="alert alert-danger">
                <?= session('message'); ?>
              </div>
            <?php endif; ?>
            <?php if (session('success') !== null) : ?>
              <div class="alert alert-success">
                <?= session('success'); ?>
              </div>
            <?php endif; ?>
          </form>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <!-- <input type="file" class="filepond" id="fileUpload" multiple> -->
        </div>
        <div class="col-md-4">
          <div id="folderTree"></div>
        </div>
        <div class="col">
          <!-- Contenedor Visualzador PDF -->
          <iframe id="pdfViewer" style="width: 100%; height: 500px; border: none; display: none;"></iframe>
        </div>
      </div>

    </div>
  </div>
</div>

<script>

</script>

<script>
  $(document).ready(function() {
    // Inicializar jstree
    $('#folderTree').jstree({
      check_callback: true, // Permitir crear, renombrar y eliminar nodos
      core: {
        data: [
          { id: "1", text: 'Procedimientos', "icon": "ti ti-folder", type: "folder"},
          { id: "2", text: 'Formatos', "icon": "ti ti-folder", type: "folder"},
          { id: "3", text: 'Politicas', "icon": "ti ti-folder", type: "folder"},
          { id: "4", text: 'Instructivos', "icon": "ti ti-folder", type: "folder"},
          { id: "5", text: 'Documentos de Apoyo', "icon": "ti ti-folder", type: "folder"},
          { id: "6", text: 'Organigramas', "icon": "ti ti-folder", type: "folder"},
          { id: "7", text: 'Cartas Proyecto', "icon": "ti ti-folder", type: "folder"},
          { id: "8", text: 'Presentaciones', "icon": "ti ti-folder", type: "folder"},
        ]
      },
      plugins: ['contextmenu', 'types'], 
      contextmenu: {
        items: function(node) {
          return {
            create: {
              label: 'Crear carpeta',
              action: function() {
                $('#folderTree').jstree().create_node(node, { text: 'Nueva carpeta' });
              }
            },
            rename: {
              label: 'Renombrar carpeta',
              action: function() {
                $('#folderTree').jstree().edit(node);
              }
            },
            delete: {
              label: 'Eliminar carpeta',
              action: function() {
                $('#folderTree').jstree().delete_node(node);
              }
            }
          };
        }
      }
    });
  });

</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
  FilePond.create(document.querySelector('#fileUpload'), {
    credits:false,
    server: {
      url: '/upload', // Endpoint del backend para la subida
      process: {
        url: '/upload', // URL donde se suben los archivos
        method: 'POST',
        onload: function(response) {
          console.log('Archivo subido:', response);
        }
      },
      revert: '/revert', // Permite revertir la carga
      load: '/load' // Cargar archivos previamente subidos
    }
  });

  // Detectar la carpeta seleccionada
  $('#folderTree').on('select_node.jstree', function(e, data) {
    var selectedFolder = data.node.text;
    console.log('Carpeta seleccionada:', selectedFolder);

    // Aquí puedes enviar la carpeta seleccionada al backend con la carga del archivo
  });
});

</script>