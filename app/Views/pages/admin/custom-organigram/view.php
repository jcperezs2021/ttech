<div class="min__h__100">
  <div class="container__organization">
    <div class="row">
      <div class="col-12">
        <div class="text-center py-2 container">
          <div class="row">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-semibold mb-0"><?= $organigrama->name ?></h3>
                <div class="d-flex gap-2">
                  <a href="<?= base_url('custom-organigram/edit/'.$organigrama->id) ?>" class="btn btn-outline-secondary">
                    <i class="ti ti-pencil"></i> Editar
                  </a>
                  <a href="<?= base_url('custom-organigram') ?>" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left"></i> Volver
                  </a>
                </div>
              </div>
              <?php if($organigrama->description): ?>
                <p class="text-muted mt-2"><?= $organigrama->description ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card b-s-none" style="padding-top: 120px !important;">
    <div id="chart-container" class="min__h__100">
      <div class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <p class="mt-3 text-muted">Cargando organigrama...</p>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  const organigramaId = <?= $organigrama->id ?>;

  // Cargar datos del organigrama
  $.ajax({
    url: `<?= base_url('custom-organigram/data/') ?>${organigramaId}`,
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      if (data && data.id) {
        renderOrganigram(data);
      } else {
        $('#chart-container').html(`
          <div class="text-center py-5">
            <i class="ti ti-alert-circle fs-1 text-warning"></i>
            <p class="mt-3 text-muted">No hay empleados en este organigrama</p>
            <a href="<?= base_url('custom-organigram/edit/'.$organigrama->id) ?>" class="btn btn-primary mt-2">
              Agregar Empleados
            </a>
          </div>
        `);
      }
    },
    error: function() {
      $('#chart-container').html(`
        <div class="text-center py-5">
          <i class="ti ti-alert-circle fs-1 text-danger"></i>
          <p class="mt-3 text-muted">Error al cargar el organigrama</p>
        </div>
      `);
    }
  });

  function renderOrganigram(data) {
    // Verificar si existe la biblioteca orgchart (jQuery)
    if (typeof $.fn.orgchart === 'undefined') {
      console.error('jQuery OrgChart library not loaded');
      $('#chart-container').html(`
        <div class="text-center py-5">
          <p class="text-danger">Error: Biblioteca de organigrama no cargada</p>
        </div>
      `);
      return;
    }

    try {
      // Limpiar el contenedor primero
      $('#chart-container').empty();
      
      // Procesar los datos para convertir niveles en nodos ghost
      const processedData = processNodeLevels(data);
      
      $('#chart-container').orgchart({
        'data': processedData,
        'nodeContent': 'title',
        'createNode': function($node, data) {
          if (data.img) {
            $node.prepend('<img class="node-img" src="' + data.img + '" alt="' + data.name + '">');
          }
          if (data.ghost) {
            $node.addClass('ghost__node');
            $node.addClass('ghost__node__niveles__' + data.niveles);
          } else {
            $node.addClass('normal__node');
          }
        }
      });

    } catch (error) {
      console.error('Error rendering orgchart:', error);
      $('#chart-container').html(`
        <div class="text-center py-5">
          <p class="text-danger">Error al renderizar el organigrama</p>
        </div>
      `);
    }
  }

  // Función para procesar los niveles y crear nodos ghost
  function processNodeLevels(node) {
    if (!node) return null;

    // Si el nodo tiene niveles > 0, crear nodos ghost intermedios
    if (node.niveles && node.niveles > 0) {
      // Crear el primer nodo ghost
      let firstGhostNode = {
        name: '',
        title: '',
        ghost: true,
        niveles: 1,
        children: []
      };

      // Crear cadena de nodos ghost
      let currentNode = firstGhostNode;
      for (let i = 1; i < node.niveles; i++) {
        let ghostNode = {
          name: '',
          title: '',
          ghost: true,
          niveles: i + 1,
          children: []
        };
        currentNode.children = [ghostNode];
        currentNode = ghostNode;
      }

      // Agregar el nodo real al final de la cadena de ghosts
      let actualNode = {
        id: node.id,
        name: node.name,
        title: node.title || '',
        img: node.img || '',
        ghost: false
      };

      // Procesar los hijos del nodo original
      if (node.children && node.children.length > 0) {
        actualNode.children = node.children.map(child => processNodeLevels(child));
      }

      currentNode.children = [actualNode];
      return firstGhostNode;
    } else {
      // No tiene niveles, procesar normalmente
      let processedNode = {
        id: node.id,
        name: node.name,
        title: node.title || '',
        img: node.img || '',
        ghost: false
      };

      if (node.children && node.children.length > 0) {
        processedNode.children = node.children.map(child => processNodeLevels(child));
      }

      return processedNode;
    }
  }

  // Función para convertir el árbol al formato de jQuery OrgChart (sin niveles anidados)
  function convertToOrgChartFormat(node) {
    if (!node) return null;

    let orgNode = {
      name: node.name,
      title: node.title || '',
      img: node.img || '',
      ghost: false
    };

    // Si tiene niveles, agregar nodos fantasma como hermanos con estructura especial
    if (node.niveles && node.niveles > 0) {
      // Crear estructura con nodos fantasma
      let currentNode = orgNode;
      
      for (let i = 0; i < node.niveles; i++) {
        let ghostNode = {
          name: '',
          title: '',
          ghost: true,
          niveles: i + 1,
          children: []
        };
        currentNode.children = [ghostNode];
        currentNode = ghostNode;
      }
      
      // Agregar el nodo real como hijo del último fantasma
      let realNode = {
        name: node.name,
        title: node.title || '',
        img: node.img || '',
        ghost: false
      };
      
      // Si el nodo original tiene hijos, agregárselos al nodo real
      if (node.children && node.children.length > 0) {
        realNode.children = node.children.map(child => convertToOrgChartFormat(child));
      }
      
      currentNode.children = [realNode];
      
      return orgNode;
    } else {
      // Procesar hijos normalmente
      if (node.children && node.children.length > 0) {
        orgNode.children = node.children.map(child => convertToOrgChartFormat(child));
      }
      return orgNode;
    }
  }
});
</script>
