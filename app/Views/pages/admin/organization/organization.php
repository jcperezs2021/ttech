<div class="container-fluid p-0">
  <div class="card b-s-none ttech__container">
    <div id="tree"></div>
  </div>
</div>

<script>
    let nodes = <?php echo json_encode($org); ?>;
    let chart = new OrgChart("#tree", {
        filterBy: ['title', 'name'],
        mode: 'light',
        tags: {
          filter: {
            template: 'dot'
          }
        },
        enableSearch: true,
        mouseScrool: OrgChart.action.none,
        nodeBinding: {
            field_0: "name",
            field_1: "title",
            img_0: "img"
        },
        menu: {
            pdf: { text: "Export PDF" },
            png: { text: "Export PNG" },
        },
        nodes
    });
</script>