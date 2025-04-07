$(document).ready(function() {

    function showOrganization() {
        $.ajax({
            'url': base_url + 'organization/data',
            'dataType': 'json'
        })
        .done(function(data) {
            datascource = data;
            $('#chart-container').empty(); // Limpia el contenedor del organigrama
            $('#chart-container').orgchart({
                'data': data,
                'nodeContent': 'title',
                'createNode': function($node, data) {
                    if (data.img) {
                        $node.prepend('<img class="node-img" src="' + data.img + '" alt="' + data.name + '">');
                    }
                    if(data.ghost) {
                        $node.addClass('ghost__node');
                    }else{
                        $node.addClass('normal__node');
                    }
                }
            });
        });
    }

    // Despliegue inicial
    showOrganization();
});