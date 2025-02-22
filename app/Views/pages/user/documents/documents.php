<style>
  main {
    margin: 60px auto;
    position: relative;
    width: 200px;
}

.main-folder-part {
    background-image: linear-gradient(180deg, #72BAFB 0%, #347EE1 100%);
    box-shadow: inset 0 1px 3px 0 rgba(255,255,255,0.50), 0 -2px 2px rgba(0,0,0,0.1);
    border-radius: 5px;
    height: 150px;
    position: relative;
    width: 200px;
}
.main-folder-part:after {
    content:'';
    box-shadow: 0 8px 8px 0 rgba(114,186,251,0.60);
    border-radius: 10px;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
}

.back-folder-part {
    height: 150px;
    position: absolute;
    width: 200px;
}
.back-folder-part:after {
    background: #5CA4F1;
    border-radius: 5px 5px 0 0;
    content:'';
    height: 20px;
    position: absolute;
    top: -15px;
    width: 150px;
}
.back-folder-part:before {
    background: #5CA4F1;
    border-radius: 0 5px 0 0;
    content:'';
    height: 10px;
    position: absolute;
    right: 2px;
    top: -6px;
    width: 150px;
}

.add-icon {
    background-image: linear-gradient(179deg, #B6F9A5 0%, #79C166 95%);
    border-radius: 9999px;
    bottom: -15px;
    box-shadow: 0 4px 12px 0 rgba(79,140,62,0.40), inset 0 1px 3px 0 rgba(255,255,255,0.50);
    height: 50px;
    right: -15px;
    position: absolute;
    width: 50px;
}
.add-icon:before, .add-icon:after {
    background: #5D9D4D;
    border-radius: 9999px;
    content: '';
    position: absolute;
}
.add-icon:after {
    box-shadow: inset 0 1px 3px 0 rgba(0,0,0,0.10), 0 1px 0 rgba(255,255,255,0.6);
    height: 24px;
    left: calc(50% - 2px);
    top: calc(50% - 12px);
    width: 4px;
}
.add-icon:before {
    box-shadow: inset 0 1px 3px 0 rgba(0,0,0,0.10), 0 1px 0 rgba(255,255,255,0.6);
    height: 4px;
    left: calc(50% - 12px);
    top: calc(50% - 2px);
    width: 24px;
}
</style>

<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Documentos</h5>

      <div class="row">
        <div class="col-md-3">
          <!-- Contenedor Archivos -->
          <div id="folderTree"></div>
        </div>
        <div class="col">
        <main>
            <div class="back-folder-part"></div>
            <div class="main-folder-part"></div>
            <div class="add-icon"></div>
            Iconos
        </main>
          <!-- Contenedor Visualzador PDF -->
          <iframe id="pdfViewer" style="width: 100%; height: 500px; border: none; display: none;"></iframe>
        </div>
      </div>

      <!-- Funciones JS -->
      <script>
        $('#folderTree').jstree({
          'core': {
            'data': [
              { "id": "1", "text": "Procedimientos", "icon": "ti ti-folder", "type": "folder" },
              { "id": "2", "text": "Cartas Proyecto", "icon": "ti ti-folder", "type": "folder" },
              { "id": "3", "text": "Formatos", "icon": "ti ti-folder", "type": "folder", "children": [
                { "id": 6, "text": "Archivo PDF", "icon": "ti ti-file", "type": "pdf", "file": "assets/test/pdf.pdf" },
                { "id": 7, "text": "Archivo XLS", "icon": "ti ti-file", "type": "xls", "file": "assets/test/excel.xlsx" },
                { "id": 8, "text": "Ibrahim archivo", "icon": "ti ti-user", "type": "ibrahim", "file": "assets/test/excel.xlsx" },
              ]},
            ]
          }
        });

        // Muestra el archivo al seleccionar un nodo
        $('#folderTree').on('select_node.jstree', function (e, data) {
          let selectedNode = data.node.original;
          console.log("ID del nodo:", selectedNode.id);
          if (selectedNode.type === "pdf") {
            $('#pdfViewer').attr('src', selectedNode.file).show();
          } else if (selectedNode.type === "xls") {
            window.location.href = selectedNode.file;
          } else if (selectedNode.type === "folder") {
            return
          }else{
            alert("Visualización no soportada para este tipo de archivo.");
          }
        });

      </script>
      
    </div>
  </div>
</div>
