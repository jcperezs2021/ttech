<div class="min__h__100">
  <div class="card b-s-none">
    <div class="org__container" id="tree"></div>
  </div>
</div>

<script>

    OrgChart.SEARCH_PLACEHOLDER = "Buscar";
    let nodes = <?php echo json_encode($org); ?>;
    let chart = new OrgChart("#tree", {
        filterBy: ['Puesto', 'Nombre'],
        mode: 'light',
        tags: {
          filter: {
            template: 'dot'
          }
        },
        enableSearch: true,
        mouseScrool: OrgChart.action.none,
        nodeBinding: {
            field_0: "Nombre",
            field_1: "Puesto",
            img_0: "img"
        },
        nodes
    });
</script>